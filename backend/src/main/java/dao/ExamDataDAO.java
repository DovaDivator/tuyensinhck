package dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import org.json.JSONArray;
import org.json.JSONObject;

public class ExamDataDAO {

    public static JSONArray fetchExamList(Connection conn, String id) throws SQLException {
    	String sql =
    		    "SELECT " +
    		    "  CASE tc.he " +
    		    "    WHEN 'dh' THEN 'Đại học' " +
    		    "    WHEN 'cd' THEN 'Cao đẳng' " +
    		    "    WHEN 'lt' THEN 'Liên thông' " +
    		    "    ELSE 'Không xác định' " +
    		    "  END AS he, " +

    		    "  tc.khoa AS khoa, " +

    		    "  (SELECT mh.name FROM mon_hoc mh WHERE mh.mon_nn = tc.mon_nn) AS monNN, " +
    		    "  (SELECT mh.name FROM mon_hoc mh WHERE mh.mon_nn = tc.mon_tc) AS monTC, " +

    		    "  JSON_OBJECT( " +
    		    "    'diemToan', tc.diem_toan, " +
    		    "    'diemVan', tc.diem_van, " +
    		    "    'diemTC', tc.diem_tc, " +
    		    "    'diemNN', tc.diem_nn " +
    		    "  ) AS ketQua, " +

    		    "  ( " +
    		    "    SELECT JSON_ARRAYAGG( " +
    		    "      JSON_OBJECT( " +
    		    "        'ttMon', dst.mon_thi, " +
    		    "        'maPhong', dst.ma_phong, " +
    		    "        'viTri', ( " +
    		    "          SELECT pt.vi_tri " +
    		    "          FROM phong_thi pt " +
    		    "          WHERE pt.ma_phong = dst.ma_phong " +
    		    "        ), " +
    		    "        'dateExam', DATE_ADD( " +
    		    "          dst.ngay_thi, " +
    		    "          INTERVAL ( " +
    		    "            SELECT ct.delay_day " +
    		    "            FROM ca_thi ct " +
    		    "            WHERE ct.ma_ca = dst.ma_ca " +
    		    "          ) DAY " +
    		    "        ), " +
    		    "        'timeStart', ( " +
    		    "          SELECT ct.time_start " +
    		    "          FROM ca_thi ct " +
    		    "          WHERE ct.ma_ca = dst.ma_ca " +
    		    "        ), " +
    		    "        'timeEnd', ( " +
    		    "          SELECT ct.time_end " +
    		    "          FROM ca_thi ct " +
    		    "          WHERE ct.ma_ca = dst.ma_ca " +
    		    "        ) " +
    		    "      ) " +
    		    "    ) " +
    		    "    FROM ds_thi dst " +
    		    "    WHERE dst.exam_id = tc.exam_id " +
    		    "  ) AS dsThi " +

    		    "FROM thi_cu tc WHERE tc.stu_id = ?;";
    	
        JSONArray resultArray = new JSONArray();

        try  {
        	PreparedStatement stmt = conn.prepareStatement(sql);
        	stmt.setString (1, id);
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                JSONObject json = new JSONObject();
                json.put("he", rs.getString("he"));
                json.put("khoa", rs.getString("khoa"));
                json.put("monNN", rs.getString("monNN"));
                json.put("monTC", rs.getString("monTC"));
                json.put("ketQua", new JSONObject(rs.getString("ketQua")));
                json.put("dsThi", rs.getString("dsThi") != null ? new JSONArray(rs.getString("dsThi")) : new JSONArray());
                resultArray.put(json);
            }
        } catch( SQLException ex ) {
        	ex.printStackTrace();
        	throw ex;
        }

        return resultArray;
    }
}