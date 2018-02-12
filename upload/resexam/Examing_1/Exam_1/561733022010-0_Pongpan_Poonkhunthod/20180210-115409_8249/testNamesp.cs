using System;

class TestNSP{
    public static void Main(string[] args){
        string str = "";
        str = Console.ReadLine();
        Console.WriteLine("{0}",Reverse(str));
        // Console.WriteLine("{0}",str);
    }

    public static string Reverse( string s )
    {
        char[] charArray = s.ToCharArray();
        Array.Reverse( charArray );
        return new string( charArray );
    }
}


// namespace TestNSP{
//     public class PrintHelloWorld {
// 		public void print(){
// 			Console.WriteLine("Love C#");
// 		}
//     }
// }
