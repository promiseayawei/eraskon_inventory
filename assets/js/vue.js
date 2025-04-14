const { createApp } = Vue;

const main = "https://enetworkstechnologiesltd.com/api/";

createApp({
	data() {
		return {
			userAuth: {
				// fullname: "",
				email: "",
				phone: "",
				password: "",
			},
			successStatus: [200, 201, "success", true],
			userLogin: {
				email: "",
				password: "",
			},
			loading: {
				btn: false,
			},
			state: {
				error: "error",
				success: "success",
			},
			sidebarDropdown: {
				x: false,
				y: false,
			},
		};
	},

	methods: {
		createToastIcon: function () {
			// Success SVG
			const successIcon = document.createElementNS("http://www.w3.org/2000/svg", "svg");
			successIcon.setAttribute("width", "1024");
			successIcon.setAttribute("height", "1024");
			successIcon.setAttribute("viewBox", "0 0 1024 1024");

			const successPath = document.createElementNS("http://www.w3.org/2000/svg", "path");
			successPath.setAttribute("fill", "currentColor");
			successPath.setAttribute(
				"d",
				"M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896m-55.808 536.384l-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.27 38.27 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336z"
			);
			successIcon.appendChild(successPath);

			// Failure SVG
			const failureIcon = document.createElementNS("http://www.w3.org/2000/svg", "svg");
			failureIcon.setAttribute("width", "48");
			failureIcon.setAttribute("height", "48");
			failureIcon.setAttribute("viewBox", "0 0 48 48");

			const failureDefs = document.createElementNS("http://www.w3.org/2000/svg", "defs");
			const mask = document.createElementNS("http://www.w3.org/2000/svg", "mask");
			mask.setAttribute("id", "ipSCaution0");

			const maskGroup = document.createElementNS("http://www.w3.org/2000/svg", "g");
			maskGroup.setAttribute("fill", "none");
			maskGroup.setAttribute("stroke-width", "4");

			const failurePath1 = document.createElementNS("http://www.w3.org/2000/svg", "path");
			failurePath1.setAttribute("fill", "#fff");
			failurePath1.setAttribute("fill-rule", "evenodd");
			failurePath1.setAttribute("stroke", "#fff");
			failurePath1.setAttribute("stroke-linejoin", "round");
			failurePath1.setAttribute("d", "M24 5L2 43h44z");
			failurePath1.setAttribute("clip-rule", "evenodd");

			const failurePath2 = document.createElementNS("http://www.w3.org/2000/svg", "path");
			failurePath2.setAttribute("stroke", "#000");
			failurePath2.setAttribute("stroke-linecap", "round");
			failurePath2.setAttribute("d", "M24 35v1m0-17l.008 10");

			maskGroup.appendChild(failurePath1);
			maskGroup.appendChild(failurePath2);
			mask.appendChild(maskGroup);
			failureDefs.appendChild(mask);
			failureIcon.appendChild(failureDefs);

			const failurePath = document.createElementNS("http://www.w3.org/2000/svg", "path");
			failurePath.setAttribute("fill", "currentColor");
			failurePath.setAttribute("d", "M0 0h48v48H0z");
			failurePath.setAttribute("mask", "url(#ipSCaution0)");

			failureIcon.appendChild(failurePath);

			const pendingIcon = document.createElementNS("http://www.w3.org/2000/svg", "svg");
			pendingIcon.setAttribute("width", "24");
			pendingIcon.setAttribute("height", "24");
			pendingIcon.setAttribute("viewBox", "0 0 24 24");

			const pendingPath = document.createElementNS("http://www.w3.org/2000/svg", "path");
			pendingPath.setAttribute("fill", "currentColor");
			pendingPath.setAttribute(
				"d",
				"M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2M7 13.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5s1.5.67 1.5 1.5s-.67 1.5-1.5 1.5m5 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5s1.5.67 1.5 1.5s-.67 1.5-1.5 1.5m5 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5s1.5.67 1.5 1.5s-.67 1.5-1.5 1.5"
			);

			pendingIcon.appendChild(pendingPath);

			return { failureIcon, successIcon, pendingIcon };
		},

		showToast: function (message, status = "error") {
			const { failureIcon, successIcon, pendingIcon } = this.createToastIcon();
			let stat = {
				textClr: "",
				icon: "",
				bgClr: "",
			};
			switch (status.toLowerCase()) {
				case "error":
				case "failed":
					stat.bgClr = "#fff0f0";
					stat.icon = failureIcon;
					stat.textClr = "#e60000";
					break;
				case "pending":
					stat.bgClr = "#faead1";
					stat.icon = pendingIcon;
					stat.textClr = "#dc7609";
					break;
				case "success":
					stat.icon = successIcon;
					stat.bgClr = "#ecfdf3";
					stat.textClr = "#068d33";
					break;
				default:
					break;
			}

			const toastContent = document.createElement("div");
			toastContent.classList.add("d-flex", "align-items-center", "column-gap-2");
			toastContent.appendChild(stat.icon);
			const textNode = document.createElement("span");
			textNode.textContent = message;
			toastContent.appendChild(textNode);

			Toastify({
				duration: 2500,
				gravity: "top", // `top` or `bottom`
				node: toastContent,
				position: "right", // `left`, `center` or `right`
				stopOnFocus: true, // Prevents dismissing of toast on hover
				className: "ms-auto me-2",
				style: {
					backgroundColor: `${stat.bgClr}`,
					backgroundImage: "none",
					color: `${stat.textClr}`,
					borderRadius: "3px",
					boxShadow: "rgba(0, 0, 0, 0.18) 0px 2px 4px",
				},
				onClick: function () {},
			}).showToast();
		},

		fullURL: function (urlSubPart) {
			if (!urlSubPart) return console.log("Error with url");
			return `${main}${urlSubPart.trim()}`;
		},

		capFirstLetterOfWord: function (word) {
			return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
		},

		validateAuthData: function (userObj) {
			let isValid = true;
			for (const key of Object.keys(userObj)) {
				if (!userObj[key].trim()) {
					this.showToast(`${this.capFirstLetterOfWord(key)} is required.`, this.state.error);
					isValid = false;
					return;
				}
			}
			const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
			if (userObj.email && !emailPattern.test(userObj.email)) {
				this.showToast("Please enter a valid email address.", this.state.error);
				isValid = false;
				return;
			}
			const phonePattern = /^[0-9]{11}$/;
			if (userObj.phone && !phonePattern.test(userObj.phone)) {
				this.showToast("Please enter a valid phone number (11 digits).", this.state.error);
				isValid = false;
				return;
			}
			if (userObj.password && userObj.password.length < 6) {
				this.showToast("Password must be at least 6 characters.", this.state.error);
				isValid = false;
				return;
			}
			return isValid;
		},

		registerUser: async function () {
			this.loading.btn = true;

			const userObj = {
				email: this.userAuth.email.trim(),
				phone: this.userAuth.phone.trim(),
				password: this.userAuth.password.trim(),
			};

			if (!this.validateAuthData(userObj)) {
				this.loading.btn = false;
				return;
			}
			const url = "users/signUp";

			const fd = new FormData();
			fd.append("email", userObj.email.trim());
			fd.append("phone", userObj.phone.trim());
			fd.append("password", userObj.password.trim());

			try {
				const response = await fetch(this.fullURL(url), {
					body: fd,
					method: "POST",
					headers: {
						Accept: "application/json",
					},
				});
				const result = await response.json();
				if (result && result.status !== 200) {
					this.showToast(result.message || "An error occurred. Please try again.", this.state.error);
				} else {
					console.log(result);
				}
			} catch (error) {
				this.loading.btn = false;
				if (error) {
					console.log(error);
					this.showToast(error || "An error occurred. Please try again.", this.state.error);
				}
			} finally {
				this.loading.btn = false;
			}
		},

		loginUser: async function () {
			this.loading.btn = true;

			const userObj = {
				email: this.userAuth.email.trim(),
				password: this.userAuth.password.trim(),
			};
			if (!this.validateAuthData(userObj)) {
				this.loading.btn = false;
				return;
			}
			const url = "users/login";

			const fd = new FormData();
			fd.append("email", userObj.email.trim());
			fd.append("password", userObj.password.trim());

			try {
				const response = await fetch(this.fullURL(url), {
					body: fd,
					method: "POST",
					headers: {
						Accept: "application/json",
					},
				});
				const result = await response.json();
				console.log(result);
				if (result && result.status !== 200) {
					this.showToast(result.message || "An error occurred. Please try again.", this.state.error);
				} else {
					const { message, token } = result;
					localStorage.setItem("userToken", token);
					this.showToast(message, this.state.success);
				}
			} catch (error) {
				this.loading.btn = false;
				if (error) {
					this.showToast(error || "An error occurred. Please try again.", this.state.error);
				}
			} finally {
				this.loading.btn = false;
			}
		},

		resetPassword: async function () {
			this.loading.btn = true;

			const userObj = {
				email: this.userAuth.email.trim(),
			};

			if (!this.validateAuthData(userObj)) {
				this.loading.btn = false;
				return;
			}
			const url = "users/forgetPassword";

			const fd = new FormData();
			fd.append("email", userObj.email);
			fd.append("password", userObj.password);

			try {
				const response = await fetch(this.fullURL(url), {
					body: fd,
					method: "POST",
					headers: {
						Accept: "application/json",
					},
				});
				const result = await response.json();
				if (result && result.status !== 200) {
					this.showToast(result.message || "An error occurred. Please try again.", this.state.error);
				} else {
					this.showToast(result.message, this.state.success);
				}
			} catch (error) {
				this.loading.btn = false;
				if (error) {
					this.showToast(error || "An error occurred. Please try again.", this.state.error);
				}
			} finally {
				this.loading.btn = false;
			}
		},

		toggleSidebar: function () {
			const html = document.querySelector("html");
			if (!html) return;
			html.classList.add("layout-menu-expanded");
			// :class=""
			// console.log(html);
		},
	},
}).mount("#v-wrapper");
