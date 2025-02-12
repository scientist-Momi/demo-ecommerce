import axiosClient from "../axios";

export function login({ commit }, data) {
  return axiosClient.post("/login", data).then(({ data }) => {
    // commit("setUser", data.user);
    commit("setToken", data.token);
    return data;
  });
}

export function getCurrentUser({ commit }) {
  const token = sessionStorage.getItem("TOKEN");

  return axiosClient
    .post(
      "/user",
      {},
      {
        // headers: {
        //   Authorization: `Bearer ${token}`
        // },
      }
    )
    .then(({ data }) => {
      console.log(data.data);
      commit("setUser", data.data);
      console.log("get current user action");
      return data;
    })
    .catch((error) => {
      commit("clearUser");
      commit("clearToken");
      console.error("Error fetching current user:", error);
      throw error;
    });
}

export function logout({ commit }) {
  commit("clearUser");
  commit("clearToken");
}

export function sendVerifyToken({ commit }, data) {
  return axiosClient.post("/send-verification-email", data).then(({ data }) => {
    return data;
  });
}

export function verifyToken({ commit }, data) {
  return axiosClient.post("/verify-token", data).then(({ data }) => {
    return data;
  });
}

export function createUser({ commit }, data) {
  return axiosClient.post("/register", data).then(({ data }) => {
    return data;
  });
}
export function createCustomer({ commit }, data) {
  return axiosClient.post("/customer/register", data).then(({ data }) => {
    return data;
  });
}

export function fetchAdminUsers(
  { commit },
  { page = 1, search = "", role = "" } = {}
) {
  commit("setAdminUsers", [true, null]);

  return axiosClient
    .get(`/admin-users`, {
      params: {
        page,
        search,
        role,
      },
    })
    .then((response) => {
      const data = response.data;
      console.log(data);
      commit("setAdminUsers", [false, data]);
      return data;
    })
    .catch((error) => {
      console.error("Error fetching admin users:", error);
      commit("setAdminUsers", [false, null]);
      throw error;
    });
}

export function fetchCustomers(
  { commit },
  { page = 1, search = "", isLocked = null } = {}
) {
  commit("setCustomers", [true, null]);

  return axiosClient
    .get(`/customers`, {
      params: {
        page,
        search,
        isLocked,
      },
    })
    .then((response) => {
      const data = response.data;
      console.log(data);
      commit("setCustomers", [false, data]);
      return data;
    })
    .catch((error) => {
      console.error("Error fetching customers:", error);
      commit("setCustomers", [false, null]);
      throw error;
    });
}

export function fetchCustomerOrders(
  { commit },
  { userId, page = 1, search = "", status = "" } = {} 
) {
  commit("setCustomerOrders", [true, null]); 

  return axiosClient
    .get(`/customers/${userId}/orders`, {
      
      params: {
        page, 
        search, 
        status, 
      },
    })
    .then((response) => {
      const data = response.data;
      console.log(data);
      commit("setCustomerOrders", [false, data]); 
      return data;
    })
    .catch((error) => {
      console.error("Error fetching orders:", error);
      commit("setCustomerOrders", [false, null]); 
      throw error;
    });
}


export function deleteUser({ commit }, userId) {
  return axiosClient.delete(`/admin-users/${userId}`).then(({ data }) => {
    return data;
  });
}

export async function updateUserPassword(
  { commit },
  { userId, password, sendPasswordToUser }
) {
  try {
    const response = await axiosClient.put(`/admin-users/${userId}/password`, {
      password,
      sendPasswordToUser,
    });

    // Handle successful update here, if necessary
    return response.data;
  } catch (error) {
    // Handle error case
    console.error("Failed to update password:", error);
    throw error; // Re-throw error so it can be handled in the component
  }
}

export async function updateUser({ commit }, payload) {
  const {
    userId,
    firstname,
    lastname,
    phone,
    address,
    city,
    state,
    postal_code,
    country,
  } = payload;

  try {
    const response = await axiosClient.put(`/admin-users/${userId}/user`, {
      firstname,
      lastname,
      phone,
      address,
      city,
      state,
      postal_code,
      country,
    });

    // You can commit the response data to a Vuex mutation if needed
    // commit('UPDATE_USER', response.data);

    return response.data; // Return the response data to handle it in the component
  } catch (error) {
    console.error("Failed to update user:", error);
    throw error; // Re-throw the error so it can be handled in the component
  }
}

export function fetchPages({ commit }) {
  axiosClient.get("/page").then((response) => {
    commit("setPages", response.data);
    return response;
  });
}

export function fetchCustomer({ commit }, userId) {
  axiosClient.get(`/customer/${userId}`).then((response) => {
    commit("setCustomer", response);
    return response;
  });
}

export function fetchPermissions({ commit }, userId) {
  axiosClient.get(`/admin-users/${userId}/permissions`).then((response) => {
    commit("setUserPermissions", { userId, permissions: response.data });
  });
}

export function setIsConfirmed({ commit }, isConfirmed) {
  commit("setDecisionConfirm", isConfirmed);
}

export function setIsSuccess({ commit }, isSuccess) {
  commit("setDecisionSuccess", isSuccess);
}
