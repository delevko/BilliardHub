#include <iostream>
#include <cstdlib>
#include <cmath>
#include <fstream>
#include <sstream>
using namespace std;

int tournamentID;

int firstPowerOf2(const int N)
{
	int x = 1;
	while( x < N )
		x *= 2;
	return x;
}

int dataInit(int players, const int seeded)
{
	int N;

	if(seeded == 0)
	{
		N = firstPowerOf2(players);
		return N-1;
	}
	else
	{
		N = seeded*2;
		players -= seeded;
	
		int add_R = (players-1) / seeded;
		
		return (N-1 + add_R*seeded);
		
	}
}

string to_string(const int x)
{
	ostringstream stm;
	stm << x;
	return stm.str();
}

int generateTest(const int N, const int seeded, const int matches)
{
	int counter = 1;
	string s1 = "UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=";
	string s2 = " AND M.counter=";
	string s3 = " AND M.roundType=\"K/O\";\n";

	string s4 = "UPDATE matchDetails MD SET MD.status=\"Finished\" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=";

	string s5 = " AND M.counter=";
	string s6 = " AND M.roundType=\"K/O\");\n";

	string filename = to_string(tournamentID)+"KO"+to_string(N)+"-"+to_string(seeded)+".sql";
	ofstream outputTest(filename.c_str(), ios::app);
	if(!outputTest)
	{
		cout << "Could not open file " << filename << " for writing\n";
		return -1;
	}

	outputTest << "-- K/O\n\n";
	for(int i = 1; i <= matches; ++i)
	{
		outputTest << s1 << tournamentID << s2 << i << s3;
		outputTest << s4 << tournamentID << s5 << i << s6;

		outputTest << "\n";
	}

	outputTest.close();
}

int main(int argc, char** argv)
{
	int N, seeded, matches;

	if(argc != 4)
	{
		cout << "Error. Input type:\n./KO tournamentID players seeded\n";
		return -1;
	}
	else
	{
		tournamentID = atoi(argv[1]);
		N = atoi(argv[2]);
		seeded = atoi(argv[3]);
	}	

	matches = dataInit(N, seeded);
	
	cout << "\nTotal matches " << matches << "\n\n";
	
	if( generateTest(N, seeded, matches) != -1 )
		cout << "Test OK\n\n";
	else
		cout << "Test FAILED\n\n";

	return 0;
}
