const express = require('express');
require('dotenv').config();
const app = express();
const mongoose = require('mongoose');
const route = require('./routes/BlogRoute');
app.use(express.json());
mongoose.connect(
  process.env.MONGODB_URI || "mongodb://localhost/CRUD",
  { useNewUrlParser: true, 
    useUnifiedTopology: true }
)
.then(() => console.log('MongoDB Connected'))
  .catch(err => console.log(err))



app.use("/api/blogs", route);

const PORT = process.env.PORT || 8080;

app.listen(PORT, () => {
  console.log('Example app listening on port: ' + PORT );
});