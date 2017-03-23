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
		FIRST, STORE, LOGIN, CREATE, CHECKOUT, CONFIRM;
	}
	
			
	public void init(ServletConfig config) throws ServletException {
		super.init(config);
    }	
	
	public void doPost (HttpServletRequest request, 
                                    HttpServletResponse response)
					throws ServletException, IOException {
	
	
		response.setContentType("text/html");
		//forces the client to request pages from the servlet instead of using cached data
		response.setHeader("Cache-control", "no-cache, no-store, must-revalidate");
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

			//allows queries to be executed on the database	
			Statement statement = connection.createStatement();

			//a new session
			if(session.isNew()) {
				session.setAttribute("isNew", true);
				session.setAttribute("state", State.FIRST);
			}
			else {
				session.setAttribute("isNew", false);
			}
			
			//set timeout to 15 minutes
			session.setMaxInactiveInterval(900);
		
			//State transitions
			State state = (State)session.getAttribute("state");
			writeToFile("before: " + state.toString(), out);
			String next = request.getParameter("next");
			writeToFile("next: " + next, out);
			boolean logError = false;
			switch(state) {
				//we must be logged out in state FIRST
				case FIRST:	if ("log".equals(next)) /* log in */{
								session.setAttribute("state", State.LOGIN);
								session.setAttribute("after", State.STORE);
							}
							else if ("co".equals(next)) /* checkout */{
								session.setAttribute("state", State.LOGIN);
								session.setAttribute("after", State.CHECKOUT);
								saveCart(session, request, out);
							}
							//else just arrived or refreshed - same for other states
						  	break;
				//we must be logged in in state STORE
				case STORE: if ("log".equals(next)) /* log out */{
								session.invalidate();
								response.setHeader("Refresh", "1;Store");
								out.println("<html><body>logging out...</body></html>");
								out.flush();
								connection.close();
								out.close();
								return;
							}	
							else if ("co".equals(next)) /* checkout */{
								session.setAttribute("state", State.CHECKOUT);
								saveCart(session, request, out);
							}
							break;
				case LOGIN: //check if username and password match/exist
							String username = request.getParameter("username");
							String password = request.getParameter("password");
							boolean isMatch = false;
							ResultSet results = statement.executeQuery("SELECT * FROM rjuserpwd");
							while (results.next()) {
								if (results.getString(1).equals(username) && results.getString(2).equals(password)) {
									isMatch = true;
									break;
								}
							}
							if (isMatch) {
								session.setAttribute("user", username);
								State after = (State)session.getAttribute("after");
								session.setAttribute("state", after);
							}
							else {
								logError = true;
							}
							break;
				case CREATE://check if username and password match/exist
							if (true) /* TODO: need to put some logic to determine */{
								State after = (State)session.getAttribute("after");
								session.setAttribute("state", after);
							}
							else if (false){
								logError = true;
							}
							break;
				case CHECKOUT: 	if ("order".equals(next)) {
										writeToFile("in order",out);
									session.setAttribute("state", State.CONFIRM);
									//save order
									//get attributes and parameters
									String name = request.getParameter("realname");
									String mail = request.getParameter("mailbox");
									String id   = request.getParameter("id");
									String usrname = (String)session.getAttribute("user");
									Cart cart = (Cart)session.getAttribute("cart");
									String price = Double.toString(cart.totCost());
									writeToFile("past getters",out);
									//insert a new order
									statement.executeUpdate("INSERT INTO cs4220.rjorders (order_id, username, totalprice, name, mailbox, student_id) VALUES (NULL, '"+usrname+"', '"+price+"', '"+name+"', '"+mail+"', '"+id+"');");
									writeToFile("first statement",out);
									//order_id is auto incremented, so we find whichever order_id is the largest
									ResultSet resultSet = statement.executeQuery("SELECT max(order_id) FROM rjorders;");
									writeToFile("second statement",out);
									resultSet.next();
									String orderID = resultSet.getString(1);
									writeToFile("start of third", out);
									//insert an order item for each item in the cart
									for (int i = 0; i < cart.size(); i++) {
										String itemID = Integer.toString(cart.getItem(i).getId());
										statement.executeUpdate("INSERT INTO rjorderitem (o_id, i_id) VALUES ('"+orderID+"', '"+itemID+"');");
									}
									writeToFile("done with third", out);
							   	}
								else if ("log".equals(next)) {
									session.invalidate();
									response.setHeader("Refresh", "1;Store");
									out.println("<html><body>logging out...</body></html>");
									out.flush();
									connection.close();
									out.close();
									return;
								}
							   	break;
				case CONFIRM: 	//go back to the store, keep the user logged in, but use a new cart
								if ("store".equals(next)) {
									session.setAttribute("state", State.STORE);
									session.setAttribute("isNew", true);
								}
								else if ("log".equals(next)) {
									session.invalidate();
									response.setHeader("Refresh", "1;Store");
									out.println("<html><body>logging out...</body></html>");
									out.flush();
									connection.close();
									out.close();
									return;
								}
							  	break;
				default: /*Error*/
			}
			//Generate HTML
			out.println(headString(session));
			out.println("<body>");

			state = (State)session.getAttribute("state");
			writeToFile("after: " + state.toString(), out);
			String text = headerString(session);
			switch(state) {
				case FIRST:
				case STORE: /* TODO: load in cart if not new */
							text += ""
							+ "<div id='content' class='connectedSortable ui-droppable'>\n";
							ResultSet results = statement.executeQuery("SELECT id,name,description,price FROM rjcart");
							while (results.next()) {
								String id = results.getString(1);
								String name = results.getString(2);
								String desc = results.getString(3);
								String price = results.getString(4);
								text+="<div class='item'>\n"
									+ "		<input class='id' type='text' name='id' value='"+id+"'/>\n"
									+ "		<input type='text' name='name' value='"+name+"' readonly/>\n"
									+ "		<input type='text' name='desc' value='"+desc+"' readonly/>\n"
									+ "		<input type='text' name='price' value='"+price+"' readonly/>\n"
									+ " 	<input type='checkbox' name='itemBox'/>\n"
									+ "		<span class='liner'>"+desc+"</span>\n"      
                					+ "		<span class='liner amount'>"+price+"</span>\n"
                					+ " 	<span class='liner'>"+name+"</span>\n"
									+ "</div>\n";
							}
            				text += ""
               				+ "</div>\n"
        					+ "<footer>\n"
            				+ "	<form action='Store?next=co' method='POST'>\n"
							+ "		<div id='left' class='connectedSortable ui-droppable'></div>\n"
            				+ "		<div id='right'>\n"
							+ "			<button type='button' onclick='addtocart()'>Add to Cart</button>\n"
              				+ "			<p id='count'># items: 0</p>\n"
              				+ "  		<p id='cost'>Total Price: $0.00</p>\n"
              				+ "			<button type='submit'>Check out</button>\n"
           					+ "		</div>\n"
							+ "	</form>\n"
       						+ "</footer>\n";
							break;
				case LOGIN: text += ""
							+ "<div id='wrapper'>\n"
							+ "	<form action='Store' method='POST'>\n"
							+ " 	<label for='usr'>Username:</label>\n"
							+ "		<input id='usr' name='username' placeholder='Api' required='' type='text' autofocus=''>\n"
							+ "		<br/>\n"
							+ "		<label for='pwd'>Password:</label>\n"
							+ "		<input id='pwd' name='password' placeholder='is_da_best_dog' required='' type='password' autocomplete='off'>\n"
							+ "		<br/>\n"
							+ "		<button type='submit'>Login</button>\n"
							+ "	</form>\n";
							if (logError) {
								text += "<p>Your username and/or password didn't match our records. Did you get enough sleep?</p>\n";
							}
							text += "<div>\n";
							break;
				case CREATE: text += "create\n";
							 break;
				case CHECKOUT: Cart cart = (Cart)session.getAttribute("cart");
							   text += ""
							   + "<div id='content'>\n"
							   + "	<div id='wrapper'>\n"
							   + "		<form action='Store?next=order' method='POST'\n"
							   + "			<p>Ready to check out!</p>\n"
							   + "			<br/>\n"
							   + "			<span id='count'># items: "+cart.size()+"</span><br/>\n"
							   + "			<span id='cost'>Total Price: $"+cart.totCost()+"</span><br/>\n"
							   + "			<label for='name'>Full Name:</label>\n"
						   	   + "	   		<input id='name' name='realname' placeholder='Api the American Eskimo' required='' type='text' pattern='[A-Za-z][A-Za-z ]*' title='Full name; only letters allowed' autofocus=''/>\n"
							   + "			<br/>\n"
							   + "			<label for='mail'>Mailbox #:</label>\n"
							   + "			<input id='mail' name='mailbox' placeholder='3296' required='' type='text' pattern='^[0-9]{4}$' title='Four number CU postal code'/>\n"
							   + "			<br/>\n"
							   + "			<label for='id'>Student ID:</label>\n"
							   + "			<input id='id' name='id' placeholder='3334444' required='' type='text' pattern='^[0-9]{7}$' title='Seven digit student ID'/>\n"
							   + "			<button type='submit'>Place Order</button>\n"
							   + "		</form>\n"
							   + "	</div>\n"
							   + "</div>\n"
							   + "<footer>\n";
							   for (int i = 0; i < cart.size(); i++) {
									Item item = cart.getItem(i);
									text += ""
										 + "	<div class='item'>\n"
							   			 + "		<span class='liner'>"+item.getDesc()+"</span>\n"      
                			   			 + "		<span class='liner amount'>"+item.getPrice()+"</span>\n"
                			   			 + " 		<span class='liner'>"+item.getName()+"</span>\n"
							   			 + "	</div>\n";
							   }
							   text += "</footer>\n";

							   break;
				case CONFIRM: text+="confirm\n";
							  break;
				default: /*Error*/
							  out.println("state: " + state);
							  out.println("<br/>");
							  out.println("next:  " + next);
			}
		
			//Statement statement = connection.createStatement();
			//ResultSet results = statement.executeQuery("SELECT name,description,price FROM rjcart");

			//Debug function to print out result

			/*for (int i = 1; i <= results.getMetaData().getColumnCount(); i++) {
				out.print(results.getMetaData().getColumnName(i) + " ");
			}
			out.println("<br>");
			while (results.next()) {
				for (int i = 1; i <= results.getMetaData().getColumnCount(); i++) {
					out.println(results.getString(i) + " ");
				}
				out.println("<br>");
			}
			*/
			
			out.println(text);
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
	
	/* saves the cart information from the store form to the session */
	private void saveCart(HttpSession session, HttpServletRequest request, PrintWriter out) {
		Cart cart = new Cart();
		String ids[] = request.getParameterValues("id");
		String names[] = request.getParameterValues("name");
		String descs[] = request.getParameterValues("desc");
		String prices[] = request.getParameterValues("price");
		//each array should be the same size
		for (int i = 0; i < ids.length; i++) {
			Item item = new Item(Integer.parseInt(ids[i]), names[i], descs[i], Double.parseDouble(prices[i]));
			cart.addItem(item);
		}
		session.setAttribute("cart", cart);
	}

	/* Provides beginning/meta data for document; closing html tag must be provided elsewhere */
	private String headString(HttpSession session) {
		String stateStr = "";
		State state = (State)session.getAttribute("state");
		switch(state) {
			case FIRST:
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
		+ "   </head>\n";
		
		return text;
	}
	
	/* Provides HTML for header used throughout the site */
	private String headerString(HttpSession session) {
			/* TODO: welcome new user or returning user */
			String logStr;
			State state = (State)session.getAttribute("state");
			switch(state) {
				case FIRST: logStr = "<a href='?next=log'>Log in</a>\n";
							break;
				case STORE:
				case CHECKOUT:
				case CONFIRM: logStr = "<a href='?next=log'>Log out</a>\n";
							  break;
				case LOGIN:
				case CREATE: 
				default: logStr = "";
			}
			String text = ""				
						+ "<header>\n"
            			+ "	<h1>API's Junk</h1>\n"
            			+ "	<div class='dropdown'>\n"
                		+ "		<button class='dropbtn'>Links</button>\n"
                		+ "		<div class='dropdown-content'>\n"
						+ logStr			
                    	+ "			<a href='http://judah.cedarville.edu/~jrussel/cs3220.html'>Homepage</a>\n"
                    	+ "			<a href='http://judah.cedarville.edu/peopleschoice/index.php'>People's Choice Awards</a>\n"
                		+ "		</div>\n"
            			+ "	</div>\n"
        				+ "</header>\n";
			return text;
	}

}
