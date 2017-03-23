import java.util.ArrayList;

public class Cart {
	private final ArrayList<Item> items;

	public Cart() {
		items = new ArrayList<>();
	}

	public void addItem(Item i) {
		items.add(i);
	}

	public Item getItem(int index) {
		return items.get(index);
	}

	public int size() {
		return items.size();
	}

	public double totCost() {
		double totCost = 0.0;
		for (Item item1 : items) {
			totCost += item1.getPrice();
		}
		return totCost;
	}
}
