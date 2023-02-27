import Proposal from "./proposal";
import Profile from "./profile";
import Group from "./group";

export default interface Bookmark {
    id: number;
    title: string;
    model: Proposal | Profile | Group;
}
