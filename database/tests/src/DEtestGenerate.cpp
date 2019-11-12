#include <iostream>
#include <cstdlib>
#include <cmath>
#include <fstream>
#include <sstream>
using namespace std;

int N; //total players
int LOW_R, UP_R, KO_R;
int tournamentID;

int dataInit(const int KO_matches)
{
	if(N/4 < KO_matches)
	{
		cout << "Error. (total_players/4) < KO_matches\n";
		cout << "Input type:\n./DE tournamentID total_players KO_matches\n";
		return -1;
	}

	KO_R = log2(KO_matches*2);
	UP_R = log2(N/KO_matches);
	LOW_R = 2*(UP_R-1);
	
	return 1;
}

string to_string(const int x)
{
	ostringstream stm;
	stm << x;
	return stm.str();
}

int generateTest(const int KO_matches)
{
	int counter = 1;
	string s1 = "UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=";
	string s2 = " AND M.counter=";
	string s3 = " AND M.roundType=";

	string s4 = "UPDATE matchDetails MD SET MD.status=\"Finished\" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=";

	string s5 = " AND M.counter=";
	string s6 = " AND M.roundType=";

	string filename = to_string(tournamentID)+"DE"+to_string(N)+"-"+to_string(KO_matches)+".sql";
	ofstream outputTest(filename.c_str(), ios::app);
	if(!outputTest)
	{
		cout << "Could not open file " << filename << " for writing\n";
		return -1;
	}
	
	for(int i = 1; i <= UP_R; ++i)
	{
		outputTest << "-- UP " << i << "\n";
		for(int j = counter; j < counter+N/pow(2,i); ++j)
		{
			outputTest << s1 << tournamentID << s2 << j << s3 << "\"UP\"" << ";\n";
			outputTest << s4 << tournamentID << s5 << j << s6 << "\"UP\");\n";
		}
		counter = counter+N/pow(2,i);
		outputTest << "\n";
	}
	outputTest << "\n";
	for(int i = 1; i <= LOW_R; ++i)
	{
		outputTest << "-- LOW " << i << "\n";
		for(int j = counter; j < counter+(N/2)/pow(2,floor((i+1)/2)); ++j)
		{
			outputTest << s1 << tournamentID << s2 << j << s3 << "\"LOW\"" << ";\n";
			outputTest << s4 << tournamentID << s5 << j << s6 << "\"LOW\");\n";
		}
		counter = counter+(N/2)/pow(2,floor((i+1)/2));
		outputTest << "\n";
	}
	outputTest << "\n";
	for(int i = 1; i <= KO_R; ++i)
	{
		outputTest << "-- K/O " << i << "\n";
		for(int j = counter; j < counter+KO_matches*2/pow(2,i); ++j)
		{
			outputTest << s1 << tournamentID << s2 << j << s3 << "\"K/O\"" << ";\n";
			outputTest << s4 << tournamentID << s5 << j << s6 << "\"K/O\");\n";
		}
		counter = counter+KO_matches*2/pow(2,i);

		outputTest << "\n";
	}

	outputTest.close();
	return 1;
}

int main(int argc, char** argv)
{
	int KO_matches;

	if(argc != 4)
	{
		cout << "Error. Input type:\n./DE tournamentID total_players KO_matches\n";
		return -1;
	}
	else
	{
		tournamentID = atoi(argv[1]);
		N = atoi(argv[2]);
		KO_matches = atoi(argv[3]);
	}	

	if(dataInit(KO_matches) == -1)
	{
		cout << "Test FAILED\n";
		return -1;
	}
	
	cout << "LOW_R " << LOW_R << "\n";
	cout << "UP_R " << UP_R << "\n";
	cout << "KO_R " << KO_R << "\n\n";
	
	if( generateTest(KO_matches) != -1)
		cout << "Test OK \n\n";
	else
		cout << "Test FAILED\n\n";

	return 0;
}
