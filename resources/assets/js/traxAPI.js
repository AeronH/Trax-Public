// Mock endpoints to be changed with actual REST API implementation
let traxAPI = {
  getCarsEndpoint() {
    return "/api/car/all";
  },
  getCarEndpoint(id) {
    return "/api/car" + "/" + id;
  },
  addCarEndpoint() {
    return "/api/car/store";
  },
  deleteCarEndpoint(id) {
    return "/api/car/delete" + "/" + id;
  },
  getTripsEndpoint() {
    return "/api/trip/all";
  },
  addTripEndpoint() {
    return "/api/trip/store";
  },
};

export { traxAPI };
