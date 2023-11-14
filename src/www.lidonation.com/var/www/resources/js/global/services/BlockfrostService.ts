import route from "ziggy-js";
import axios from "@/global/utils/axios";

export default class BlockfrostService{

    static async queryFrost(endpoint: string) {        
        return (await axios.get(route('blockfrost-query', {endpoint} ))).data
    }

    static async getConfig() {
        return (await axios.get(`${window.location.origin}/api/cardano/config`))?.data;      
    }
}