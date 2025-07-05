package service;

public class ConvertCus {
	public static String canNullStringSQL(String str) {
		return str == "" ? null : str;
	}
}
