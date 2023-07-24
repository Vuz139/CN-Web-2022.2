const mongodb = require('mongoose');
const Schema = mongodb.Schema;

const blogSchema = new Schema({
    title: String,
    body: String,
    image: String,
    createdAt: {
        type: Date,
        default: Date.now
    }
})

module.exports = mongodb.model('Blog', blogSchema);