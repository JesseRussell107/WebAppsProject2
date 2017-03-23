public class Item {
	private final int id;
	private final String name;
	private final String desc;
	private final double price;

	public Item(int i, String n, String d, double p) {
		id = i;
		name = n;
		desc = d;
		price = p;
	}

	public int getId() { return id; }
	public String getName() { return name; }
	public String getDesc() { return desc; }
	public double getPrice() { return price; }
}
