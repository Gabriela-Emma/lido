import {futimes} from "fs";

export default interface CardanoWallet {
    eternl: any;
    flint: any;
    nami: any;
    typhon: any;
    enable(): any;
    isEnabled(): any;
    getNetworkId(): any;
}
