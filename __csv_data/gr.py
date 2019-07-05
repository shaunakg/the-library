from goodreads import client
gc = client.GoodreadsClient("BwqNaycM9A82dzjUA5Tg", "tIy63jzvaJMbqTPq36ZmGZz4i6j2HnfU1wnyz4F2UqQ")

write_file = open("books.txt", "w+")

books_dict = []

for i in range(0,1000):
	c_book = []

	try:
		book = gc.book(i)

		print(str(i) + "/1000 | " + book.title)
		write_file.write("\"" + str(i) + "\",")
		write_file.write("\"" + book.title.replace(",","") + "\",")
		write_file.write("\"" + book.authors[0].name + "\",")
		write_file.write("\"" + str(book.average_rating) + "\",")
		write_file.write("\"" + "Book Description not implemented yet." + "\"\n")
	except Exception as e:
		try:
			print("ERROR | " + str(e))
		except:
			print("ERROR | Some weird error happed where I couldn't even print it")
		continue