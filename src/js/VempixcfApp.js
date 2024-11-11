import VempixcfManager from "./VempixcfModel.js";

import VempixcfController from "./VempixcfController.js";
import VempixcfView from "./VempixcfView.js";


const VempixcfApp = new VempixcfController(VempixcfManager.getInstance(), new VempixcfView());

export default VempixcfApp;