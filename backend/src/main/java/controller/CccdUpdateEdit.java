package controller;

import java.io.IOException;
import java.sql.Connection;

import javax.servlet.ServletException;
import javax.servlet.annotation.MultipartConfig;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import javax.servlet.http.Part;

import org.json.JSONObject;

import dao.CccdDAO;
import dao.PasswordUpdateDAO;
import exception.UnauthorizedException;
import model.UserBasic;
import service.HttpJson;
import util.DBConnectionMain;

/**
 * Servlet implementation class CccdEdit
 */
@MultipartConfig
@WebServlet("/api/user-cccd")
public class CccdEdit extends HttpServlet {
	private static final long serialVersionUID = 1L;

	/**
	 * @see HttpServlet#HttpServlet()
	 */
	public CccdEdit() {
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
		response.getWriter().append("Served at: ").append(request.getContextPath());

	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse
	 *      response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {
		// TODO Auto-generated method stub

		JSONObject jsonResponse = new JSONObject();
		DBConnectionMain dbConn = null;
		Connection conn = null;
		try {
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
			String body = HttpJson.readRequestBody(request);
			JSONObject json = new JSONObject(body);

			String numCccd = json.getString("numCccd");
			String dateBirth = json.getString("dateBirth");
			String gender = json.getString("gender");
			String address = json.getString("address");
			String frontImg = json.getString("front");
			String backImg = json.getString("back");

			dbConn = new DBConnectionMain();
			conn = dbConn.getConnection();

			boolean success = CccdDAO.updateCccd(conn, user.getId(), numCccd, dateBirth, gender, address, frontImg,
					backImg);
			if (!success) {
				throw new UnauthorizedException("Cập nhật không thành công!");
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
