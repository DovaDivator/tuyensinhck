package dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Date;

import org.json.JSONObject;

import service.ConvertCus;
import service.HttpJson;

public class CccdUpdateDAO {
	public static boolean updateCccd(Connection conn, String id, String numCccd, String dateBirth, String gender,
			String address, String frontImg, String backImg) throws Exception {
		String checkConfirmSql = "SELECT is_confirm FROM stu_cccd WHERE stu_id = ?";
		String checkDuplicateSql = "SELECT stu_id FROM stu_cccd WHERE num_cccd = ? AND stu_id <> ?";
		String updateSql = "UPDATE stu_cccd SET num_cccd = ?, date_of_birth = ?, gender = ?, address = ?, front_cccd = ?, back_cccd = ? WHERE stu_id = ?";
        String insertSql = "INSERT INTO stu_cccd (stu_id, num_cccd, date_of_birth, gender, address, front_cccd, back_cccd, is_confirm) " +
                "VALUES (?, ?, ?, ?, ?, ?, ?, 0)";


		try (PreparedStatement duplicatestmt = conn.prepareStatement(checkDuplicateSql)) {
			duplicatestmt.setString(1, numCccd);
			duplicatestmt.setString(2, id);
			ResultSet rs = duplicatestmt.executeQuery();
			if (rs.next()) {
				throw new SQLException("Số CCCD đã tồn tại.");
			}
		}

		try (PreparedStatement confirmstmt = conn.prepareStatement(checkConfirmSql)) {
			confirmstmt.setString(1, id);
			ResultSet rs = confirmstmt.executeQuery();

			if (rs.next()) {
                int isConfirm = rs.getInt("is_confirm");
                if (isConfirm == 1) {
                    throw new SQLException("CCCD đã được xác nhận, không thể sửa.");
                } 
        		try (PreparedStatement updateStmt = conn.prepareStatement(updateSql)) {
        			updateStmt.setString(1, numCccd);
        			updateStmt.setDate(2, ConvertCus.convertStringToSqlDate(dateBirth, "dd/MM/yyyy"));
        			updateStmt.setInt(3, Integer.parseInt(gender));
        			updateStmt.setString(4, address);
        			updateStmt.setBytes(5, ConvertCus.decodeBase64(frontImg));
        			updateStmt.setBytes(6, ConvertCus.decodeBase64(backImg));
        			updateStmt.setString(7, id);
        			
        			int rowsAffected = updateStmt.executeUpdate();

        			if (rowsAffected > 0) {
        				return true;
        			}
        			return false;
        		}

			} else {
            	try (PreparedStatement insertStmt = conn.prepareStatement(insertSql)) {
                    insertStmt.setString(1, id);
                    insertStmt.setString(2, numCccd);
                    insertStmt.setDate(3, ConvertCus.convertStringToSqlDate(dateBirth, "dd/MM/yyyy"));
                    insertStmt.setInt(4, Integer.parseInt(gender));
                    insertStmt.setString(5, address);
        			insertStmt.setBytes(6, ConvertCus.decodeBase64(frontImg));
        			insertStmt.setBytes(7, ConvertCus.decodeBase64(backImg));
                    
                    int inserted = insertStmt.executeUpdate();
                    if (inserted > 0) {
                    	return true;
                    }
                    return false;
                    }
                }
            }
		
        }
	
     public static JSONObject getCccdById (Connection conn, String id) throws Exception {
         String getCccdsql = "SELECT num_cccd, date_of_birth, gender, address, front_cccd, back_cccd FROM stu_cccd WHERE stu_id = ? LIMIT 1";
 		 JSONObject cccdJson = new JSONObject();
         
 		try (PreparedStatement stmt = conn.prepareStatement(getCccdsql)) {
			stmt.setString(1, id);
			ResultSet rs = stmt.executeQuery();

			if (rs.next()) {
				cccdJson.put("numCccd", rs.getString("num_cccd"));
				
				Date date = rs.getDate("date_of_birth");
				String timeConverted = HttpJson.convertTime(date, "yyyy-MM-dd");
				cccdJson.put("dateBirth", timeConverted);
				
				cccdJson.put("gender", rs.getString("gender"));
				cccdJson.put("address", rs.getString("address"));

				byte[] frontImgBytes = rs.getBytes("front_cccd");
				String base64Front = HttpJson.convertToBase64(frontImgBytes);
				cccdJson.put("front", base64Front.isEmpty() ? JSONObject.NULL : base64Front);
				
				byte[] backImgBytes = rs.getBytes("back_cccd");
				String base64Back = HttpJson.convertToBase64(backImgBytes);
				cccdJson.put("back", base64Back.isEmpty() ? JSONObject.NULL : base64Back);

     } else {
    	 throw new Exception ("Dữ liệu trống!");
     }
	}
	return cccdJson;
}
}