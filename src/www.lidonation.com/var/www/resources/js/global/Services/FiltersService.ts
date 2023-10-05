import route from 'ziggy-js';
import axios from '../../lib/utils/axios';

export default class FiltersService {
    static async filterProposals(params) {
       return (await axios.get(route('catalystExplorer.filterProposals'), { params})).data
    }

    static async filterGroups(params) {
        return (await axios.get(route('catalystExplorer.filterGroups'), { params })).data
    }
}

