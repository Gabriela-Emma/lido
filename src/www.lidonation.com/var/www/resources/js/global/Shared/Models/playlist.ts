import Plyr from "plyr";

export default interface Playlist {
    title:string;
    provider: Plyr.Provider;
    quickpitch:string;
}