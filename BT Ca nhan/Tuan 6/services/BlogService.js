const BlogModel = require("../models/Blog");

exports.getAllBlogs = async () => {
	return await BlogModel.find();
};

// create a new blog

exports.createBlog = async (blog) => {
	return await BlogModel.create(blog);
};

exports.getBlogById = async (id) => {
	return await BlogModel.findById(id);
};

// update a blog by id

exports.updateBlog = async (id, blog) => {
	return await BlogModel.findByIdAndUpdate(id, blog, { new: true });
};

// delete a blog by id

exports.deleteBlog = async (id) => {
	return await BlogModel.findByIdAndDelete(id);
};
