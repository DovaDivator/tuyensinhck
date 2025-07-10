package dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;

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
				jsonObj.put("timeStart", HttpJson.convertTime(rs.getDate("time_start"), "HH:mm dd/MM/yyyy"));
				jsonObj.put("timeEnd", HttpJson.convertTime(rs.getDate("time_end"), "HH:mm dd/MM/yyyy"));
				jsonObj.put("dateExam", HttpJson.convertTime(rs.getDate("date_exam"), "HH:mm dd/MM/yyyy"));

				response.put(jsonObj);
			}

		} catch (Exception e) {
			throw new RuntimeException("Lỗi khi truy vấn dữ liệu kỳ thi: " + e.getMessage(), e);
		}

		return response;
	}


}
