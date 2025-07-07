package service;

import java.util.Base64;

public class ConvertCus {
	public static String canNullStringSQL(String str) {
		return str == "" ? null : str;
	}
	
	public static byte[] decodeBase64(String base64String) {
        if (base64String == null || base64String.isEmpty()) {
            return new byte[0]; // hoặc ném lỗi tùy nhu cầu
        }
        return Base64.getDecoder().decode(base64String);
    }
}
