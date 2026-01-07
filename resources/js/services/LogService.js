import { LogApiClient } from "./Api/LogApiClient";

class LogServiceClass {
  constructor() {
    this.api = new LogApiClient()
  }

  async send(body = {}) {
    try {
      const response = await this.api.post({
        endpoint:'/send',
        body
      });
      return response;
    } catch (error) {
      console.error("Log error:", error);
      throw error;
    }
  }
  async logs(vehicle_id) {
    try {
      const response = await this.api.get({
        endpoint:`/${vehicle_id}`
      });
      return response;
    } catch (error) {
      console.error("Log error:", error);
      throw error;
    }
  }
  async generateObstacles(planet_id) {
    try {
      const response = await this.api.get({
        endpoint:`generate-obstacles/${planet_id}`
      });
      return response;
    } catch (error) {
      console.error("Log error:", error);
      throw error;
    }
  }
}

export const LogService = new LogServiceClass();
