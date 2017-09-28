import java.util.Scanner;

public class Alphabet {

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		String myAlphabet ="Welcome to java";
		Scanner sc = new Scanner(System.in);
		String str = "112123123412345123456123451234123121";
		String in = "1";
		int count = 0;
		System.out.println(myAlphabet);
		System.out.println("String Lenght :"+myAlphabet.length());
		System.out.println(myAlphabet.indexOf('o'));
		System.out.println(myAlphabet.lastIndexOf('a'));
		System.out.println(myAlphabet.substring(8,15));
		System.out.println(myAlphabet.charAt(11));
		System.out.println(myAlphabet.replace('e','a'));
		System.out.println(str.length());
		
		for(int i=0;i<str.length();i++){
			if(str.charAt(i) == in.charAt(0)){
				count++;
			}
		}
		System.out.println(count);
		
	}

}
