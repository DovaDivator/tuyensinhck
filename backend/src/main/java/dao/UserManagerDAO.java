package dao;

import static util.GlobleVariables.ADMIN_LIST_USER_LIMIT;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;

import com.tuyensinh.function.HttpJson;

public class UserManagerDAO {
	public static String getTaiKhoanQuery() {
		return "SELECT u.id, u.name, u.created_at, u.is_freezing, "
				+ "CASE WHEN EXISTS (SELECT 1 FROM stu_cccd c WHERE c.stu_id = u.id) "
				+ "THEN true ELSE false END AS isxacthuc " + "FROM users u WHERE role = 1";
	}

	public static String getTaiKhoan(Connection conn, String search, String isCccd, String isFreeze, int page) {
		int offset = (page - 1) * ADMIN_LIST_USER_LIMIT;

		StringBuilder sql = new StringBuilder();
		sql.append("SELECT * FROM ( ");
		sql.append(getTaiKhoanQuery());

		sql.append(") AS sub WHERE 1=1 ");

		if (!search.isEmpty()) {
			sql.append(" AND (u.name LIKE ? OR u.id LIKE ?) ");
		}

		if (isCccd.equals("true") || isCccd.equals("false"))
			sql.append(" AND isxacthuc = ").append(isCccd);

		if (isFreeze.equals("true") || isFreeze.equals("false"))
			sql.append(" AND is_freezing = ").append(isFreeze);

		sql.append(" LIMIT ").append(ADMIN_LIST_USER_LIMIT).append(" OFFSET ").append(offset);

		StringBuilder jsonArray = new StringBuilder();
		jsonArray.append("[");

		try (PreparedStatement stmt = conn.prepareStatement(sql.toString())) {
			if (!search.isEmpty()) {
				String like = "%" + search + "%";
				stmt.setString(1, like);
				stmt.setString(2, like);
			}

			ResultSet rs = stmt.executeQuery();
			boolean first = true;

			while (rs.next()) {
				if (!first) {
					jsonArray.append(",");
				} else {
					first = false;
				}

				jsonArray.append("{").append("\"id\":\"").append(rs.getString("id")).append("\",").append("\"name\":\"")
						.append(HttpJson.convertStringToJson(rs.getString("name"))).append("\",")
						.append("\"created_at\":\"")
						.append(HttpJson.convertTime(rs.getTimestamp("created_at"), "HH:mm dd/MM/yyyy")).append("\",")
						.append("\"isxacthuc\":").append(rs.getBoolean("isxacthuc")).append(",").append("\"isFreeze\":")
						.append(rs.getBoolean("is_freezing")).append("}");
			}

		} catch (Exception e) {
			throw new RuntimeException("Lỗi khi truy vấn dữ liệu người dùng: " + e.getMessage(), e);
		}

		jsonArray.append("]");
		return jsonArray.toString();
	}

	public static String getTaiKhoanTotalPage(Connection conn, String search, String isCccd, String isFreeze) {
		StringBuilder sql = new StringBuilder();
		sql.append("SELECT COUNT(*) FROM (");
		sql.append("SELECT * FROM ( ");
		sql.append(getTaiKhoanQuery());
		sql.append(") AS sub WHERE 1=1 ");

		if (!search.isEmpty()) {
			sql.append(" AND (name LIKE ? OR id LIKE ?) ");
		}

		if (isCccd.equals("true") || isCccd.equals("false"))
			sql.append(" AND isxacthuc = ").append(isCccd);

		if (isFreeze.equals("true") || isFreeze.equals("false"))
			sql.append(" AND is_freezing = ").append(isFreeze);

		sql.append(") as total_list");

		StringBuilder jsonResult = new StringBuilder();

		try (PreparedStatement stmt = conn.prepareStatement(sql.toString())) {
			if (!search.isEmpty()) {
				String like = "%" + search + "%";
				stmt.setString(1, like);
				stmt.setString(2, like);
			}

			ResultSet rs = stmt.executeQuery();
			boolean first = true;

			int listLength = 0;
			if (rs.next()) {
				listLength = rs.getInt(1); // lấy giá trị COUNT(*)
			}

			int totalPage = HttpJson.getTotalPage(listLength, ADMIN_LIST_USER_LIMIT);
			jsonResult.append("{").append("\"totalPage\":").append(totalPage).append("}");
			return jsonResult.toString();
		} catch (Exception e) {
			throw new RuntimeException("Lỗi khi truy vấn dữ liệu người dùng: " + e.getMessage(), e);
		}
	}

	public static String getThiSinhQuery() {
		return "select tc.stu_id, " + "(select u.name from users u where u.id = tc.stu_id) as name, "
				+ "tc.exam_id, tc.he, tc.mon_tc, tc.mon_nn, "
				+ "(select mh.name from mon_hoc mh where mh.mon_nn = tc.mon_nn) as mon_nn_name, "
				+ "(select mh.name from mon_hoc mh where mh.mon_nn = tc.mon_tc) as mon_tc_name, "
				+ "(select dt.khoa_thi from ds_thi dt where dt.exam_id = tc.exam_id) as khoa_thi, "
				+ "(select dt.ma_phong from ds_thi dt where dt.exam_id = tc.exam_id and dt.ma_ca = 1) as phong1, "
				+ "(select dt.ma_phong from ds_thi dt where dt.exam_id = tc.exam_id and dt.ma_ca = 2) as phong2, "
				+ "(select dt.ma_phong from ds_thi dt where dt.exam_id = tc.exam_id and dt.ma_ca = 3) as phong3, "
				+ "(select dt.ma_phong from ds_thi dt where dt.exam_id = tc.exam_id and dt.ma_ca = 4) as phong4 "
				+ "from thi_cu tc";
	}

	public static String getThiSinh(Connection conn, String search, String optionHe, String optionKhoaThi,
			String optionTc, String optionNn, int page) {
		int offset = (page - 1) * ADMIN_LIST_USER_LIMIT;

		StringBuilder sql = new StringBuilder();
		sql.append("SELECT * FROM ( ");
		sql.append(getThiSinhQuery());

		sql.append(") AS sub WHERE 1=1 ");

		if (!search.isEmpty())
			sql.append(" AND (name LIKE ? OR stu_id LIKE ? OR exam_id LIKE ?) ");

		if (!optionHe.isEmpty())
			sql.append(" AND he = ").append(optionHe);

		if (!optionKhoaThi.isEmpty() && !optionKhoaThi.equals("0"))
			sql.append(" AND khoa_thi = ").append(optionKhoaThi);

		if (!optionTc.isEmpty())
			sql.append(" AND mon_tc = '").append(optionTc).append("'");

		if (!optionNn.isEmpty())
			sql.append(" AND mon_nn = '").append(optionNn).append("'");

		sql.append(" LIMIT ").append(ADMIN_LIST_USER_LIMIT).append(" OFFSET ").append(offset);

		StringBuilder jsonArray = new StringBuilder();
		jsonArray.append("[");

		try (PreparedStatement stmt = conn.prepareStatement(sql.toString())) {
			if (!search.isEmpty()) {
				String like = "%" + search + "%";
				stmt.setString(1, like);
				stmt.setString(2, like);
				stmt.setString(3, like);
			}

			ResultSet rs = stmt.executeQuery();
			boolean first = true;

			while (rs.next()) {
				if (!first) {
					jsonArray.append(",");
				} else {
					first = false;
				}

				jsonArray.append("{").append("\"stu_id\":\"").append(rs.getString("stu_id")).append("\",")
						.append("\"name\":\"").append(HttpJson.convertStringToJson(rs.getString("name"))).append("\",")
						.append("\"exam_id\":").append(HttpJson.getNullString(rs.getString("exam_id"))).append(",")
						.append("\"he\":").append(rs.getInt("he")).append(",").append("\"mon_tc\":\"")
						.append(HttpJson.convertStringToJson(rs.getString("mon_tc_name"))).append("\",")
						.append("\"mon_nn\":\"").append(HttpJson.convertStringToJson(rs.getString("mon_nn_name")))
						.append("\",").append("\"khoa_thi\":").append(rs.getInt("khoa_thi")).append(",")
						.append("\"phong1\":").append(HttpJson.getNullString(rs.getString("phong1"))).append(",")
						.append("\"phong2\":").append(HttpJson.getNullString(rs.getString("phong2"))).append(",")
						.append("\"phong3\":").append(HttpJson.getNullString(rs.getString("phong3"))).append(",")
						.append("\"phong4\":").append(HttpJson.getNullString(rs.getString("phong4"))).append("")
						.append("}");
			}

		} catch (Exception e) {
			throw new RuntimeException("Lỗi khi truy vấn dữ liệu người dùng: " + e.getMessage(), e);
		}

		jsonArray.append("]");
		return jsonArray.toString();
	}

	public static String getThiSinhTotalPage(Connection conn, String search, String optionHe, String optionKhoaThi,
			String optionTc, String optionNn) {
		StringBuilder sql = new StringBuilder();
		sql.append("SELECT COUNT(*) FROM (");
		sql.append("SELECT * FROM ( ");
		sql.append(getThiSinhQuery());
		sql.append(") AS sub WHERE 1=1 ");

		if (!search.isEmpty())
			sql.append(" AND (name LIKE ? OR stu_id LIKE ? OR exam_id LIKE ?) ");

		if (!optionHe.isEmpty())
			sql.append(" AND he = ").append(optionHe);

		if (!optionKhoaThi.isEmpty())
			sql.append(" AND khoa_thi = ").append(optionKhoaThi);

		if (!optionTc.isEmpty())
			sql.append(" AND mon_tc = '").append(optionTc).append("'");

		if (!optionNn.isEmpty())
			sql.append(" AND mon_nn = '").append(optionNn).append("'");

		sql.append(") as total_list");

		StringBuilder jsonResult = new StringBuilder();

		try (PreparedStatement stmt = conn.prepareStatement(sql.toString())) {
			if (!search.isEmpty()) {
				String like = "%" + search + "%";
				stmt.setString(1, like);
				stmt.setString(2, like);
				stmt.setString(3, like);
			}

			ResultSet rs = stmt.executeQuery();
			boolean first = true;

			int listLength = 0;
			if (rs.next()) {
				listLength = rs.getInt(1); // lấy giá trị COUNT(*)
			}

			int totalPage = HttpJson.getTotalPage(listLength, ADMIN_LIST_USER_LIMIT);
			jsonResult.append("{").append("\"totalPage\":").append(totalPage).append("}");
			return jsonResult.toString();
		} catch (Exception e) {
			throw new RuntimeException("Lỗi khi truy vấn dữ liệu người dùng: " + e.getMessage(), e);
		}
	}

	public static String getGiaoVienQuery() {
		return "select u.id, u.name, u.is_freezing, "
				+ "(select tm.mon_nn from tch_mgr tm where tm.tch_id = u.id) as mon_nn, "
				+ "(select mh.name from mon_hoc mh where mh.mon_nn = "
				+ "(select tm.mon_nn from tch_mgr tm where tm.tch_id = u.id) " + ") as ten_mon "
				+ "from users u where u.role = 2";
	}

	public static String getGiaoVien(Connection conn, String search, String mon, String isFreeze, int page) {
		int offset = (page - 1) * ADMIN_LIST_USER_LIMIT;

		StringBuilder sql = new StringBuilder();
		sql.append("SELECT * FROM ( ");
		sql.append(getGiaoVienQuery());

		sql.append(") AS sub WHERE 1=1 ");

		if (!search.isEmpty())
			sql.append(" AND (name LIKE ? OR id LIKE ?) ");

		if (!mon.isEmpty())
			sql.append(" AND mon_nn = '").append(mon).append("'");
		
		if (isFreeze.equals("true") || isFreeze.equals("false"))
			sql.append(" AND is_freezing = ").append(isFreeze);

		sql.append(" LIMIT ").append(ADMIN_LIST_USER_LIMIT).append(" OFFSET ").append(offset);

		StringBuilder jsonArray = new StringBuilder();
		jsonArray.append("[");

		try (PreparedStatement stmt = conn.prepareStatement(sql.toString())) {
			if (!search.isEmpty()) {
				String like = "%" + search + "%";
				stmt.setString(1, like);
				stmt.setString(2, like);
			}

			ResultSet rs = stmt.executeQuery();
			boolean first = true;

			while (rs.next()) {
				if (!first) {
					jsonArray.append(",");
				} else {
					first = false;
				}

				jsonArray.append("{").append("\"id\":").append(rs.getString("id")).append(",").append("\"name\":\"")
						.append(HttpJson.convertStringToJson(rs.getString("name"))).append("\",").append("\"mon_ql\":")
						.append(HttpJson.getNullString(HttpJson.convertStringToJson(rs.getString("ten_mon")))).append(",")
						.append("\"isFreeze\":").append(rs.getBoolean("is_freezing")).append("}");
			}

		} catch (Exception e) {
			throw new RuntimeException("Lỗi khi truy vấn dữ liệu người dùng: " + e.getMessage(), e);
		}

		jsonArray.append("]");
		return jsonArray.toString();
	}

	public static String getGiaoVienTotalPage(Connection conn, String search, String mon, String isFreeze) {
		StringBuilder sql = new StringBuilder();
		sql.append("SELECT COUNT(*) FROM (");
		sql.append("SELECT * FROM ( ");
		sql.append(getGiaoVienQuery());
		sql.append(") AS sub WHERE 1=1 ");

		if (!search.isEmpty())
			sql.append(" AND (name LIKE ? OR stu_id LIKE ? OR exam_id LIKE ?) ");

		if (!mon.isEmpty())
			sql.append(" AND mon_nn = '").append(mon).append("'");
		
		if (isFreeze.equals("true") || isFreeze.equals("false"))
			sql.append(" AND is_freezing = ").append(isFreeze);

		sql.append(") as total_list");

		StringBuilder jsonResult = new StringBuilder();

		try (PreparedStatement stmt = conn.prepareStatement(sql.toString())) {
			if (!search.isEmpty()) {
				String like = "%" + search + "%";
				stmt.setString(1, like);
				stmt.setString(2, like);
			}

			ResultSet rs = stmt.executeQuery();
			boolean first = true;

			int listLength = 0;
			if (rs.next()) {
				listLength = rs.getInt(1); // lấy giá trị COUNT(*)
			}

			int totalPage = HttpJson.getTotalPage(listLength, ADMIN_LIST_USER_LIMIT);
			jsonResult.append("{").append("\"totalPage\":").append(totalPage).append("}");
			return jsonResult.toString();
		} catch (Exception e) {
			throw new RuntimeException("Lỗi khi truy vấn dữ liệu người dùng: " + e.getMessage(), e);
		}
	}
}
