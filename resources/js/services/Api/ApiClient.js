import axios from "axios";

export default class ApiClient {
  constructor(routeRoot = "/") {
    this.client = axios.create({
      baseURL: `/api${routeRoot}`,
    });
  }

  async request(
    endpoint,
    method = "GET",
    body = null,
    headers = {},
    query = {}
  ) {
    const isFormData = body instanceof FormData;

    try {
      const response = await this.client.request({
        url: endpoint,
        method,
        headers: {
          ...headers,
          ...(body && !isFormData ? { "Content-Type": "application/json" } : {}),
        },
        params: query,   
        data: body,     
      });

      return response.data;
    } catch (error) {
      const message =
        error.response?.data?.message ||
        error.message ||
        "API request failed";

      const status = error.response?.status;
      throw new Error(status ? `${message} (status ${status})` : message);
    }
  }

  get({endpoint, headers = {}, query = {}}) {
    return this.request(endpoint, "GET", null, headers, query);
  }

  post({endpoint,body={}, headers = {}, query = {}}) {
    return this.request(endpoint, "POST", body, headers, query);
  }

  put({endpoint, headers = {}, query = {}}) {
    return this.request(endpoint, "PUT", body, headers, query);
  }

  delete({endpoint, headers = {}, query = {}}) {
    return this.request(endpoint, "DELETE", null, headers, query);
  }
}
