package dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import service.ConvertCus;

public class CccdDAO {
	public static boolean updateCccd(Connection conn, String id, String numCccd, String dateBirth, String gender,
			String address, String frontImg, String backImg) throws SQLException {
		String checkConfirmSql = "SELECT is_confirm FROM stu_cccd WHERE id = ?";
		String checkDuplicateSql = "SELECT id FROM stu_cccd WHERE num_cccd = ? AND id <> ?";
		String updateSql = "UPDATE stu_cccd SET numCccd = ?, dateBirth = ?, gender = ?, address = ?, frontImg = ?, backImg = ? WHERE id = ?";
        String insertSql = "INSERT INTO stu_cccd (id, numCccd, dateBirth, gender, address, frontImg, backImg is_confirm) " +
                "VALUES (?, ?, ?, ?, ?, ?, ?, 0)";

		try (PreparedStatement stmt = conn.prepareStatement(checkConfirmSql)) {
			stmt.setString(1, id);
			ResultSet rs = stmt.executeQuery();

			if (rs.next() && rs.getInt("is_confirm") == 1) {
				throw new SQLException("CCCD đã được xác nhận, không thể sửa.");
			} else {
            	try (PreparedStatement insertStmt = conn.prepareStatement(insertSql)) {
                    insertStmt.setString(1, numCccd);
                    insertStmt.setString(2, id);
                    insertStmt.setString(3, dateBirth);
                    insertStmt.setString(4, gender);
                    insertStmt.setString(5, address);
        			insertStmt.setBytes(6, ConvertCus.decodeBase64(frontImg));
        			insertStmt.setBytes(7, ConvertCus.decodeBase64(backImg));
                    
                    int inserted = insertStmt.executeUpdate();
                    if (inserted == 0) {
                        throw new SQLException("Thêm mới không thành công.");
                    }
                }
            }
        }

		try (PreparedStatement stmt = conn.prepareStatement(checkDuplicateSql)) {
			stmt.setString(1, numCccd);
			stmt.setString(2, id);
			ResultSet rs = stmt.executeQuery();
			if (rs.next()) {
				throw new SQLException("Số CCCD đã tồn tại.");
			}
		}

		try (PreparedStatement updateStmt = conn.prepareStatement(updateSql)) {
			updateStmt.setString(1, numCccd);
			updateStmt.setString(2, id);
			updateStmt.setString(3, dateBirth);
			updateStmt.setString(4, gender);
			updateStmt.setString(5, address);
			updateStmt.setBytes(6, ConvertCus.decodeBase64(frontImg));
			updateStmt.setBytes(7, ConvertCus.decodeBase64(backImg));

			int rowsAffected = updateStmt.executeUpdate();

			if (rowsAffected > 0) {
				return true;
			}
			return false;
		}
	}
	
	
}