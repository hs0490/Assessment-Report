# Class Heap

Heap class is a collection with underlying structure of Heap Tree. This implementation shows the use of Iterator, Null Object, Strategy and Decorator Design Patterns.

- Strategy Design Pattern -- It is used to allow your heap to be either a min heap or a max heap.
- Decorator Design Pattern -- It is used to implement IngFilter. It wil print out the elements that end in "ing".
- Iterator Design Pattern -- To iterate over elements of the heap using in-order traversal.
- Null Object Design Pattern -- It is used to remove null checks when finding the height of the heap.

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

### Constructor Summary

-  public Heap(HeapStrategy strategy) -- Constructs a Heap containing the elements of the specified type(Min Heap or MaxHeap).

### Method Details

- int size() -- Returns the number of elements in this list.

- Object[] toArray() -- Returns an array containing all of the elements in this collection.

- String toString() -- Returns String containing all of the elements in this collection.

- Iterator iterator() -- Returns an iterator over a set of elements.

-  boolean add(Object data) -- This function add HeapNode in Heap.


### TestCases

1. HeapTest
2. IngFilterTest
3. IngHeapDecoratorTest

