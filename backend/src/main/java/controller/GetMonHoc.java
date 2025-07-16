package controller;

import java.io.IOException;
import java.sql.Connection;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.json.JSONArray;
import org.json.JSONObject;

import dao.MonThiDAO;
import util.DBConnectionMain;

/**
 * Servlet implementation class GetMonHoc
 */
@WebServlet("/api/get-mon")
public class GetMonHoc extends HttpServlet {
	private static final long serialVersionUID = 1L;

	/**
	 * @see HttpServlet#HttpServlet()
	 */
	public GetMonHoc() {
		super();
		// TODO Auto-generated constructor stub
	}

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse
	 *      response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {
		// TODO Auto-generated method stub
		response.setContentType("application/json");
		response.setCharacterEncoding("UTF-8");
		JSONObject jsonResponse = new JSONObject();
		DBConnectionMain dbConn = null;
		Connection conn = null;
//	
		try {
			String type = request.getParameter("type") != null ? request.getParameter("type") : "";

			dbConn = new DBConnectionMain();
			conn = dbConn.getConnection();

			JSONArray result = new JSONArray();

			switch (type) {
			case "dang-ky": {
				JSONObject jsonData = new JSONObject();
				jsonData.put("monTC", MonThiDAO.getListMonChoice(conn, 2));
				jsonData.put("monNN", MonThiDAO.getListMonChoice(conn, 3));
				jsonResponse.put("data", jsonData);
				break;
			}
			default:
				throw new Exception("thuộc tính type không hợp lệ " + type);
			}

			jsonResponse.put("success", true);
			jsonResponse.put("message", "Lấy dữ liệu thành công!");

		} catch (Exception e) {
			response.setStatus(HttpServletResponse.SC_BAD_REQUEST);
			jsonResponse.put("success", false);
			jsonResponse.put("message", e.getMessage());
		} finally {
			if (conn != null) {
				try {
					conn.close();
				} catch (Exception e) {
					System.err.println("Không thể đóng kết nối: " + e.getMessage());
				}
			}
		}

		response.getWriter().write(jsonResponse.toString());
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse
	 *      response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {
		// TODO Auto-generated method stub
	}

}
