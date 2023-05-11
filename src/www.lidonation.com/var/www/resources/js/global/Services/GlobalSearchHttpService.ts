import axios from '../../lib/utils/axios';

export default class GlobalSearchHttpService {
  static async search(term) {
    const url = `/api/search?q=${term}`;
    const response = await axios.get(url);
      return response.data;
  }
}


