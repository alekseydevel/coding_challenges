import { router as getRoute } from "./plate/get.js";
import { router as postRoute } from "./plate/post.js";

const router = (app) => {
    app.use(getRoute);
    app.use(postRoute);
}

export { router }
