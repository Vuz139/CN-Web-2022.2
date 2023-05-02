const express = require("express");
require("dotenv").config();
const app = express();
const mongoose = require("mongoose");
const route = require("./routes/BlogRoute");
app.use(express.json());
app.set("view engine", "ejs");
mongoose
	.connect(
		process.env.MONGODB_URI ||
			"mongodb+srv://it4409:it4409-soict@lamdb-crud.qd3s7vv.mongodb.net/?retryWrites=true&w=majority",
		{ useNewUrlParser: true, useUnifiedTopology: true },
	)
	.then(() => console.log("MongoDB Connected"))
	.catch((err) => console.log(err));

app.get('/', (req, res) => {
	res.render('index')
})
app.use("/api/blogs", route);

const PORT = process.env.PORT || 8080;

app.listen(PORT, () => {
	console.log("Example app listening on port: " + PORT);
});
