#include <iostream>
#include <cstdlib>
#include <cmath>
#include <fstream>
#include <sstream>
using namespace std;

int tournamentID, nrOfMatches;

void dataInit(const int groupMin, const int players)
{
	int nrOfGroups = players/groupMin;
	int mod = players%groupMin;

	nrOfMatches = (groupMin * (groupMin+1)) / 2 * mod;
	nrOfMatches += (groupMin * (groupMin-1)) / 2 * (nrOfGroups-mod);
}

string to_string(const int x)
{
	ostringstream stm;
	stm << x;
	return stm.str();
}

int generateTest(const int groupMin, const int N)
{
	int counter = 1;
	string s1 = "UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=";
	string s2 = " AND M.counter=";
	string s3 = " AND M.roundType=\"Group\"";

	string s4 = "UPDATE matchDetails MD SET MD.status=\"Finished\" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=";
	string s5 = " AND M.counter=";
	string s6 = " AND M.roundType=\"Group\")";

	string filename = to_string(tournamentID)+"GROUP"+to_string(N)+"-"+to_string(groupMin)+".sql";
	ofstream outputTest(filename.c_str(), ios::app);
	if(!outputTest)
	{
		cout << "Could not open file " << filename << " for writing\n";
		return -1;
	}
	
	outputTest << "-- GROUPS\n";
	for(int i = 1; i <= nrOfMatches; ++i)
	{
		outputTest << s1 << tournamentID << s2 << i << s3 << ";\n";
		outputTest << s4 << tournamentID << s5 << i << s6 << ";\n";
		
		outputTest << "\n";
	}

	outputTest.close();
}

int main(int argc, char** argv)
{
	int groupMin, N;

	if(argc != 4)
	{
		cout << "Error. Input type:\n./group tournamentID groupPlayers groupMin\n";
		return -1;
	}
	else
	{
		tournamentID = atoi(argv[1]);
		N = atoi(argv[2]);
		groupMin = atoi(argv[3]);
	}	

	dataInit(groupMin, N);

	if( generateTest(groupMin, N) != -1 )
	{
		cout << "Nr of matches: " << nrOfMatches << "\n\n";
		cout << "Test OK\n\n";
	}
	else
		cout << "Test FAILED\n\n";


	return 0;
}
