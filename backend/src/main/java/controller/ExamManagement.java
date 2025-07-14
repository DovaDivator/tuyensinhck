package controller;

import java.io.IOException;
import java.sql.Connection;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.json.JSONObject;

import dao.KyThiManagerDAO;
import exception.UnauthorizedException;
import model.UserBasic;
import service.HttpJson;
import util.DBConnectionMain;

/**
 * Servlet implementation class ExamManagement
 */
@WebServlet("/api/exam")
public class ExamManagement extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public ExamManagement() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		response.getWriter().append("Served at: ").append(request.getContextPath());
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
        response.setContentType("application/json");
        response.setCharacterEncoding("UTF-8");
		JSONObject jsonResponse = new JSONObject();
		DBConnectionMain dbConn = null;
		Connection conn = null;
		try {
			String body = HttpJson.readRequestBody(request);
			
			String token = null;
			String authHeader = request.getHeader("Authorization");
			if (authHeader != null && authHeader.startsWith("Bearer ")) {
				token = authHeader.substring(7);
			} else {
				throw new UnauthorizedException("Không có Header");
			}

			response.setContentType("application/json");
			response.setCharacterEncoding("UTF-8");

			HttpSession session = request.getSession(false);
			if (session == null) {
				throw new UnauthorizedException("Session không tồn tại hoặc đã hết hạn");
			}

			UserBasic user = (UserBasic) session.getAttribute("user");
			String sessionToken = (String) session.getAttribute("token");
			if (user == null || sessionToken == null || !sessionToken.equals(token)) {
				throw new UnauthorizedException("User không tồn tại trong session");
			}
			
			JSONObject json = new JSONObject();
			try {
		        json = new JSONObject(body);
		    } catch (Exception ex) {
		        // Không thêm json nếu parse lỗi
		        System.err.println("Lỗi parse JSON: " + ex.getMessage());
		    }
			
			dbConn = new DBConnectionMain();
			conn = dbConn.getConnection();
			
			String type = request.getParameter("type");
			switch(type) {
			case "fetch": {
				boolean fetchdata = KyThiManagerDAO.fetchExamstatus(conn, user.getId());
				jsonResponse.put("data", fetchdata);
				break;
			}
		
			default:
				throw new Exception("thuộc tính type không hợp lệ " + type);
			}
			
			jsonResponse.put("success", true);
			jsonResponse.put("message", "Cập nhật thành công!");	
			
		} catch (Exception e) {
			if (e instanceof UnauthorizedException) {
				response.setStatus(HttpServletResponse.SC_UNAUTHORIZED);
			} else {
				response.setStatus(HttpServletResponse.SC_BAD_REQUEST);
			}
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

}

