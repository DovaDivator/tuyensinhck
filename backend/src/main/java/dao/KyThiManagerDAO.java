package dao;

import java.sql.Connection;
import java.sql.Date;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.Timestamp;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

import org.json.JSONArray;
import org.json.JSONObject;

import service.HttpJson;

public class KyThiManagerDAO {
	public static JSONArray getKyThi(Connection conn, String type) {
		
		StringBuilder sql = new StringBuilder();
		sql.append("SELECT loai_thi, khoa, is_add, time_start, time_end, date_exam FROM ky_thi_mgr");
		
		
		if (!type.isEmpty()) {
			sql.append(" WHERE loai_thi = ? ");
		}
		
		JSONArray response = new JSONArray();
		
		try (PreparedStatement stmt = conn.prepareStatement(sql.toString())) {
			if (!type.isEmpty()) {
				stmt.setString(1, type);
			}

			ResultSet rs = stmt.executeQuery();
			
			while (rs.next()) {
				JSONObject jsonObj = new JSONObject();
				jsonObj.put("loaiThi", rs.getString("loai_thi"));
				jsonObj.put("khoa", rs.getInt("khoa"));
				jsonObj.put("isAdd", rs.getBoolean("is_add"));
				jsonObj.put("timeStart", HttpJson.convertTime(rs.getTimestamp("time_start"), "HH:mm dd/MM/yyyy"));
				jsonObj.put("timeEnd", HttpJson.convertTime(rs.getTimestamp("time_end"), "HH:mm dd/MM/yyyy"));
				jsonObj.put("dateExam", HttpJson.convertTime(rs.getDate("date_exam"), "HH:mm dd/MM/yyyy"));

				response.put(jsonObj);
			}

		} catch (Exception e) {
			throw new RuntimeException("Lỗi khi truy vấn dữ liệu kỳ thi: " + e.getMessage(), e);
		}

		return response;
	}

	
	public static boolean updateExamTime(Connection conn, String type, String timeStartString, String timeEndString, String isAdd) throws Exception{
		if (!type.equals("dh") && !type.equals("cd") && !type.equals("lt")) {
			throw new Exception ("Loại kỳ thi không hợp lệ.");
		}
		
		DateTimeFormatter formatter = DateTimeFormatter.ofPattern("HH:mm dd/MM/yyyy");
		LocalDateTime timeStart = LocalDateTime.parse(timeStartString, formatter);
		LocalDateTime timeEnd = LocalDateTime.parse(timeEndString, formatter);
		
		String selectTimeSql = "SELECT date_exam, time_start, time_end, khoa FROM ky_thi_mgr WHERE loai_thi = ?";
		String updateTimeSql = "UPDATE ky_thi_mgr SET time_start = ?, time_end = ?, is_add = ?, khoa = ?, date_exam = NULL WHERE loai_thi = ?";
		
		try (PreparedStatement stmt = conn.prepareStatement(selectTimeSql)) {
			stmt.setString(1, type);
			ResultSet rs = stmt.executeQuery();
			
			if (!rs.next()) {
				throw new Exception ("Không tìm thấy thông tin kỳ thi.");
			}
			
			Date dateExamsql = rs.getDate("date_exam");
			LocalDateTime dateExam = null;
			
			if (dateExamsql != null) {
				dateExam = dateExamsql.toLocalDate().atStartOfDay();
			}
			
			Timestamp oldTimeEndsql = rs.getTimestamp("time_end");
			LocalDateTime oldTimeEnd = oldTimeEndsql != null ? oldTimeEndsql.toLocalDateTime() : null;
			
			int khoa = rs.getInt("khoa");
			
		     if (isAdd.equals("0")) {
		            if (dateExam != null && timeStart.isBefore(dateExam.plusDays(3))) {
		                throw new Exception("Thời gian bắt đầu phải sau ngày thi ít nhất 3 ngày.");
		            }
		        } else {
		            if (dateExam == null && oldTimeEnd != null && !timeStart.isAfter(oldTimeEnd)) {
		                throw new Exception("Thời gian bắt đầu phải sau thời gian kết thúc trước đó.");
		            }
		        }
		        try (PreparedStatement updateStmt = conn.prepareStatement(updateTimeSql)) {
		            updateStmt.setTimestamp(1, Timestamp.valueOf(timeStart));
		            updateStmt.setTimestamp(2, Timestamp.valueOf(timeEnd));
		            updateStmt.setInt(3, Integer.parseInt(isAdd));
		            updateStmt.setInt(4, isAdd.equals("0") ? ++khoa : khoa);
		            updateStmt.setString(5, type);

		            int updated = updateStmt.executeUpdate();
		            return updated > 0;
		        }
		    }
		}
}

