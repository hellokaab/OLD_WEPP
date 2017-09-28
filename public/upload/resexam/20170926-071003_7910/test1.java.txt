import java.util.Scanner;

public class test1 {

	public static void main(String[] args) {
		int n;
		String str = new String();
		String sub = new String();
		String str2 = new String(); 
		Scanner sc = new Scanner(System.in);
		n = Integer.parseInt(sc.nextLine());
		for(int i=0;i<n;i++){
			str="";
			str2="";
			str = sc.nextLine();
			for(int j=0;j<str.length();j++){
				sub = str.substring(j, j+1);
				if(sub.charAt(0) >= 'A' && sub.charAt(0)<='Z'){
					str2 += sub.replace(sub, sub.toLowerCase()); 
				}
				
				else if(sub.charAt(0) >= 'a' && sub.charAt(0)<='z'){
					str2 += sub.replace(sub, sub.toUpperCase());
				}
				
				else if(sub.charAt(0) >= '0' && sub.charAt(0)<='9'){
					str2 +='0';
				}
				else{
					str2 +='*';
				}
			}
			System.out.println(str2);
	
		}

	}

}
