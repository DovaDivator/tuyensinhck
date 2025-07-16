package dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import org.json.JSONArray;
import org.json.JSONObject;

public class MonThiDAO {
    public static JSONArray getListMonChoice(Connection conn, int filter) throws SQLException {
    	StringBuilder sql = new StringBuilder();
        sql.append("SELECT mon_nn, name FROM mon_hoc");
        
        if (filter > 1) {
			sql.append(" WHERE loai_mon = ?");
		}

        try (PreparedStatement checkStmt = conn.prepareStatement(sql.toString())) {
            checkStmt.setInt(1, filter);
            ResultSet rs = checkStmt.executeQuery();

            JSONArray response = new JSONArray();
            while (rs.next()) {
                JSONObject jsonObj = new JSONObject();
                jsonObj.put("value", rs.getString("mon_nn"));
                jsonObj.put("label", rs.getString("name"));
                
                response.put(jsonObj);
            }
            return response;

        }
    }
}
