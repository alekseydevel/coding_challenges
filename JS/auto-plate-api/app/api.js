import express from 'express';
import { router } from './routes/index.js';

const app = express();
app.use(express.json())

const PORT = 9999;

router(app);

app.listen(PORT, () => {
    console.log(`Running auto-plate-api on port ${PORT}`);
})

