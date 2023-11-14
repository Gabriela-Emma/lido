import axios, {AxiosError} from "axios";


export default class DelegatorsService {
    constructor() {
    }
    public async getPoolDetails() {
        try {
            const res = await axios.get(`${window.location.origin}/api/pool/details`);
            if (res.status == 200) {
                return res.data;
            }
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    public async getPoolBlocks() {
        try {
            const res = await axios.get(`${window.location.origin}/api/pool/blocks`);
            if (res.status == 200) {
                return res.data;
            }
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }

    public async getBlockfrostConfig() {
        try {
            const res = await axios.get(`${window.location.origin}/api/cardano/config`);
            if (res.status == 200) {
                return res.data;
            }
        } catch (e: AxiosError | any) {
            console.log({e});
        }
    }
}
