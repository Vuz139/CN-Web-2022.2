const express = require('express');

const {

    getAllBlogs,
    getBlogById,
    createBlog,
    updateBlog,
    deleteBlog

} = require('../controllers/crud');

const router = express.Router();

router.route('/').get(getAllBlogs).post(createBlog);
router.route('/:id').get(getBlogById).put(updateBlog);

module.exports = router;