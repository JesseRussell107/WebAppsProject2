
import java.io.*;
import java.util.*;
import javax.servlet.*;
import javax.servlet.http.*;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.DriverManager;
import java.sql.Connection;
import java.sql.Statement;

public class HelloWorld extends HttpServlet {

    public void init(ServletConfig config) throws ServletException {
        super.init(config);
    }

    public void doPost(HttpServletRequest request,
            HttpServletResponse response)
            throws ServletException, IOException {

        response.setContentType("text/html");
        PrintWriter out = response.getWriter();

        try {

            //read configuration properties from web.xml
            String driverName = getServletContext().getInitParameter("driver");
            String connectionName = getServletContext().getInitParameter("connection");
            String dbUsername = getServletContext().getInitParameter("username");
            String dbPassword = getServletContext().getInitParameter("password");

            //set the database driver and create a connection to the database
            Class.forName(driverName).newInstance();
            Connection connection = DriverManager.getConnection(connectionName, dbUsername, dbPassword);

            //gets current session or creates session if one does not already exist
            HttpSession session = request.getSession();

            //set timeout to 15 minutes
            session.setMaxInactiveInterval(900);

            //read in file
            BufferedReader br = new BufferedReader(new FileReader(new File("/home/students/2018/jrussel/public_html/Project4Store.html")));
            String holder = "";
            String html = "";
            while (holder != null) {
                holder = br.readLine();
                html += holder;
            }
            br.close();

//            Statement statement = connection.createStatement();
//            ResultSet results = statement.executeQuery("SELECT * FROM rjcart;");
//            String jsonString = "";
//            //Debug function to print out result
//            while (results.next()) {
//                for (int i = 1; i <= results.getMetaData().getColumnCount(); i++) {
//                    //Probably is not right
//                    jsonString += results.getString(i) + " ";
//                }
//            }
//            html = html.replace("STORE_CONTENT",jsonString);
            out.println(html);
            out.flush();
            connection.close();

            //test writing to file
            writeToFile("Hello World", out);
            out.close();

        } //on error, log to file
        catch (Exception e) {
            writeToFile(e.getMessage(), out);
        }
    }

    public void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        doPost(request, response);

    }

    //executed when the servlet destroy method is called
    public void destroy() {
    }

    private void writeToFile(String message, PrintWriter out) {
        try {
            //the folder you write to must have 777 permissions 
            //	(or at least read and write permissions for everyone)
            PrintWriter file = new PrintWriter(new FileWriter("./webapps/jrussel/WEB-INF/logs/output.log", true));
            file.println(message);
            file.close();
        } catch (Exception ex) {
            ex.printStackTrace(out);
        }
    }
}
