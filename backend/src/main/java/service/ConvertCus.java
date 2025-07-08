package service;

import java.util.Base64;

public class ConvertCus {
	public static String canNullStringSQL(String str) {
		return str == "" ? null : str;
	}
	
	public static byte[] decodeBase64(String base64String) {
	    if (base64String == null || base64String.isEmpty()) {
	        return new byte[0];
	    }

	    // Nếu có dạng "data:image/...;base64,", thì bỏ phần này đi
	    if (base64String.contains(",")) {
	        base64String = base64String.substring(base64String.indexOf(",") + 1);
	    }

	    return Base64.getDecoder().decode(base64String);
	}
}
