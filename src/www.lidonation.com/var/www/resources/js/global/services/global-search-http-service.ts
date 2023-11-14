import axios from '@/global/utils/axios';

export default class GlobalSearchHttpService {
  static async search(term) {
    const url = `/api/s?q=${term}`;
    const response = await axios.get(url);
      return response.data;
  }
}


