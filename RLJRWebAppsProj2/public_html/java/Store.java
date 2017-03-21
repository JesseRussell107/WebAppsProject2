import java.io.*;
import java.util.*;
import javax.servlet.*;
import javax.servlet.http.*;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.DriverManager;
import java.sql.Connection;
import java.sql.Statement;

public class Store extends HttpServlet {

	public enum State {
		NEW, STORE, LOGIN, CREATE, CHECKOUT, CONFIRM
	}
        		
	public void init(ServletConfig config) throws ServletException {
		super.init(config);
    }	
	
	public void doPost (HttpServletRequest request, 
                                    HttpServletResponse response)
					throws ServletException, IOException {
	
	
		response.setContentType("text/html");
		PrintWriter out = response.getWriter();
		
		try{
	
	
			//read configuration properties from web.xml
			String driverName = getServletContext().getInitParameter("driver");
			String connectionName = getServletContext().getInitParameter("connection"); 
			String dbUsername = getServletContext().getInitParameter("username"); 
			String dbPassword = getServletContext().getInitParameter("password"); 

			//set the database driver and create a connection to the database
			Class.forName(driverName).newInstance();
			Connection connection = DriverManager.getConnection(connectionName,dbUsername,dbPassword);		
					
			//gets current session or creates session if one does not already exist
			HttpSession session = request.getSession();

			//sets whether the session is new or not
			if(session.isNew()) {
				session.setAttribute("isNew", true);
				session.setAttribute("state", State.NEW);
			}
			else {
				session.setAttribute("isNew", false);
			}
			
			//set timeout to 15 minutes
			session.setMaxInactiveInterval(900);
		
			//State transitions
			State state = (State)session.getAttribute("state");
			boolean isLoggedIn = (boolean)session.getAttribute("loggedIn");
			if (isLoggedIn == null) {
				session.setAttribute("loggedIn", false);
				isLoggedIn = false;
			}
			switch(state) {
				case NEW: session.setAttribute("state", State.STORE);
						  break;
				//if in the store, we can either log in/out or we can attempt to checkout
				case STORE:	String next = request.getParameter("next");
							//clicked checkout
							if (next == null) {
								if (isLoggedIn) {
									session.setAttribute("state", State.CHECKOUT);
								}
								else {
									session.setAttribute("state", State.LOGIN);
									session.setAttribute("next", State.CHECKOUT);
								}
							}
							//clicked login or logout
							else {
								//logging in
								if (!isLoggedIn) {
									session.setAttribute("state", State.LOGIN);
									session.setAttribute("next", State.STORE);
								}
								//logging out
								else {
									//TODO
									//session.ivalidate();
									//session = request.getSession();
								}
							}
							break;
				case LOGIN: int hi;
							break;
				case CREATE: int hi;
							 break;
				case CHECKOUT: int hi;
							   break;
				case CONFIRM: int hi
							  break;
				default: /**Error**/
			}

			//Generate HTML
			out.println(headString(session));
			out.println("<body>");

			state = (State)session.getAttribute("state");
			switch(state) {
				case STORE: int hi;
							break;
				case LOGIN: int hi;
							break;
				case CREATE: int hi;
							 break;
				case CHECKOUT: int hi;
							   break;
				case CONFIRM: int hi
							  break;
				case NEW:
				default: /**Error**/
			}
		
			Statement statement = connection.createStatement();
			ResultSet results = statement.executeQuery("SELECT name,description,price FROM rjcart");

			//Debug function to print out result

			for (int i = 1; i <= results.getMetaData().getColumnCount(); i++) {
				out.print(results.getMetaData().getColumnName(i) + " ");
			}
			out.println("<br>");
			while (results.next()) {
				for (int i = 1; i <= results.getMetaData().getColumnCount(); i++) {
					out.println(results.getString(i) + " ");
				}
				out.println("<br>");
			}
			
			out.println("</body>");
			out.println("</html>");
			out.flush();
			connection.close();
			
			out.close();}
		//on error, log to file
		catch(Exception e){
			writeToFile(e.getMessage(), out);
		} 
	}					
		
	public void doGet (HttpServletRequest request, HttpServletResponse response)
						throws ServletException, IOException {
            
		doPost(request, response);
   	
	}
   
    //executed when the servlet destroy method is called
	public void destroy() {}
	
	private void writeToFile(String message, PrintWriter out){
		try{
			//the folder you write to must have 777 permissions 
			//	(or at least read and write permissions for everyone)
			PrintWriter file = new PrintWriter(new FileWriter("./webapps/lively/WEB-INF/logs/output.log", true));
			file.println(message);
			file.close();
		}
		catch(Exception ex){
			ex.printStackTrace(out);
		}
	}
	
	/* Provides beginning of document; closing html tag must be provided elsewhere */
	private String headString(HTMLSession session) {
		String stateStr = "";
		State state = (State)session.getAttribute("state");
		switch(state) {
			case STORE: stateStr = "store";
						break;
			case LOGIN: stateStr = "login";
						break;
			case CREATE: stateStr = "create";
						 break;
			case CHECKOUT: stateStr = "checkout";
						   break;
			case CONFIRM: stateStr = "confirm";
						  break;
			case NEW:
			default: /**Error**/
		}
		String text = ""
		+ "<!DOCTYPE html>\n"
		+ "<html>\n"
		+ "   <head>\n"
		+ "       <title>API's Junk</title>\n"
		+ "       <meta charset='UTF-8'/>\n"
		+ "       <meta name='viewport' content='width=device-width, initial-scale=1.0'/>\n"
		+ "       <meta name='description' content='Simple store for a simple dog'/>\n"
		+ "       <meta name='author' content='Jesse Russell and Rich Lively'/>\n"
		+ "       <link rel='icon' href='img/api.png'/>\n"
		+ "\n"
		+ "       <!-- CSS Sylesheets -->\n"
		+ "       <link rel='stylesheet' href='//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>\n"
		+ "       <link rel='stylesheet' type='text/css' href='//cdn.datatables.net/1.10.13/css/jquery.dataTables.css'>\n"
		+ "       <link rel='stylesheet' href='css/store_main.css' type='text/css'/>\n"
		+ "       <link rel='stylesheet' href='css/store_"+stateStr+".css' type='text/css'/>\n"
		+ "\n"
		+ "       <!-- JQuery -->\n"
		+ "       <script src='https://code.jquery.com/jquery-1.12.4.js'></script>\n"
		+ "       <script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>\n"
		+ "\n"
		+ "       <!-- Personal JS -->\n"
		+ "       <script type='text/javascript' src='script/store.js'></script>\n"
		+ "   </head>\n"
		
		return text;
	}
}
