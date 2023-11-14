import route from 'ziggy-js';
import axios from "@/global/utils/axios";

export default class FiltersService {
    static async filterProposals(params: { [x: string]: any; } | null) {        
        return params ? (await axios.get(route('catalyst-explorer.filter-proposals'), { params})).data : null
    }

    static async filterGroups(params: { [x: string]: any; } | null) {
        return params ? (await axios.get(route('catalyst-explorer.filter-groups'), { params })).data : null
    }

    static async filterPeople(params: { [x: string]: any; } | null) {
        return params ? (await axios.get(route('catalyst-explorer.filter-people'), { params })).data : null
    }
}

