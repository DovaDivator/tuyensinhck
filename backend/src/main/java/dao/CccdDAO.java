package dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;


public class CccdDAO {
	public static boolean updateCccd(Connection conn, String id, String numCccd, String dateBirth, String gender, String address, String frontImg, String backImg) throws SQLException {
		String checkConfirmSql = "SELECT is_confirm FROM stu_cccd WHERE id = ?";
		String checkDuplicateSql = "SELECT id FROM stu_cccd WHERE num_cccd = ? AND id <> ?";
        String updateSql = "UPDATE stu_cccd SET numCccd = ?, dateBirth = ?, gender = ?, address = ? WHERE id = ?";

		try (PreparedStatement stmt = conn.prepareStatement(checkConfirmSql)) {
			stmt.setString(1, id);
			ResultSet rs = stmt.executeQuery();

	        if (rs.next() && rs.getInt("is_confirm") == 1) {
                throw new SQLException("CCCD đã được xác nhận, không thể sửa.");
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
            updateStmt.setString(6, frontImg);
            updateStmt.setString(7, backImg);

            int rowsAffected = updateStmt.executeUpdate();

            if (rowsAffected > 0) {
                return true;
            }
            return false;
	}
}
}