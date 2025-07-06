package dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.ResultSet;

public class PasswordUpdateDAO {
    public static boolean updatePassword(Connection conn, String name, String curPass, String newPass) throws SQLException {
        String checkSql = "SELECT password FROM users WHERE username = ?";
        String updateSql = "UPDATE users SET password = ? WHERE username = ?";

        try (PreparedStatement checkStmt = conn.prepareStatement(checkSql)) {
            checkStmt.setString(1, name);
            ResultSet rs = checkStmt.executeQuery();

            if (!rs.next()) {
                System.out.println("Không tìm thấy người dùng.");
                return false; // User không tồn tại
            }

            String storedPassword = rs.getString("password");
            if (!storedPassword.equals(curPass)) {
                System.out.println("Sai mật khẩu hiện tại.");
                return false; // Wrong password
            }
        }

        try (PreparedStatement updateStmt = conn.prepareStatement(updateSql)) {
            updateStmt.setString(1, newPass);
            updateStmt.setString(2, name);
            int rowsAffected = updateStmt.executeUpdate();

            if (rowsAffected > 0) {
                System.out.println("Cập nhật mật khẩu thành công.");
                return true;
            } else {
                System.out.println("Cập nhật thất bại.");
                return false;
            }
        }
    }
}