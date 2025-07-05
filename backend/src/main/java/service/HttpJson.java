package service;

import java.io.BufferedReader;
import java.io.IOException;
import java.sql.Timestamp;
import java.text.SimpleDateFormat;
import java.util.TimeZone;

import javax.servlet.http.HttpServletRequest;

public class HttpJson {
	public static String convertStringToJson(String str) {
	    if (str == null) return "";
	    return str.replace("\\", "\\\\")
	              .replace("\"", "\\\"")
	              .replace("\n", "\\n")
	              .replace("\r", "\\r")
	              .replace("\t", "\\t");
	}
	
	public static String readRequestBody(HttpServletRequest request) throws IOException {
        StringBuilder sb = new StringBuilder();
        String line;
        BufferedReader reader = request.getReader();
        while ((line = reader.readLine()) != null) {
            sb.append(line);
        }
        return sb.toString();
    }
	
	public static String convertTime(Timestamp time, String format) {
		SimpleDateFormat sdf = new SimpleDateFormat(format);
		sdf.setTimeZone(TimeZone.getTimeZone("UTC"));
		return sdf.format(time);
	}
	
	public static int getTotalPage(int total, int limit) {
		int pageCount = (int) Math.ceil((double) total / limit);
		if (pageCount == 0) pageCount = 1;
		return pageCount;
		
	}
	
	public static String getNullString(String str) {
		if (str == null) {
			return "null";
		}
		return "\"" + str + "\"";
	}
}
