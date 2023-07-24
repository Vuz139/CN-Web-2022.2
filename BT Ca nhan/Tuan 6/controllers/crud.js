const blogService = require("../services/BlogService");

exports.getAllBlogs = async (req, res) => {
	try {
		const blogs = await blogService.getAllBlogs();
		// console.log(blogs);
		const data = blogs;
		res.render("Blog", {
			data,
			status: "success",
			port: process.env.PORT || 8080,
		});
	} catch (err) {
		res.status(500).json({
			err: err.message,
		});
	}
};
exports.createBlog = async (req, res) => {
	try {
		const blog = await blogService.createBlog(req.body);
		res.json({ data: blog, status: "success" });
	} catch (err) {
		res.status(500).json({ error: err.message });
	}
};

exports.getBlogById = async (req, res) => {
	try {
		const blog = await blogService.getBlogById(req.params.id);
		res.json({ data: blog, status: "success" });
	} catch (err) {
		res.status(500).json({ error: err.message });
	}
};

exports.updateBlog = async (req, res) => {
	try {
		const blog = await blogService.updateBlog(req.params.id, req.body);
		res.json({ data: blog, status: "success" });
	} catch (err) {
		res.status(500).json({ error: err.message });
	}
};

exports.deleteBlog = async (req, res) => {
	try {
		const blog = await blogService.deleteBlog(req.params.id);
		res.json({ data: blog, status: "success" });
	} catch (err) {
		res.status(500).json({ error: err.message });
	}
};
