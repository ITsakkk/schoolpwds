#include<iostream>
using namespace std;
int main(){
	int l, w, a, p;
	cout<<"Length: ";cin>>l;
	cout<<"Width: ";cin>>w;
	
	a = l * w;
	p = 2 * (l + w);
	cout<<"Area of the rectangle: "<<a<<endl;
	cout<<"Perimeter of the rectangle: "<<p<<endl;
}
