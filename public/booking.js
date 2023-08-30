const { createApp } = Vue;

createApp({
    data() {
        return {
            departureInfo: null,
            numberOfSeats: "",
            serverMessage: null,
            busInfo: null,
            seatList: [],
            pendingSeatList: [],
            bookedSeatsList: [],
            selectedSeatsList: [],
            bookingInfo: null,
        };
    },
    mounted() {
        this.checkBusSeatsAvailability();
    },
    methods: {
        useScrollToPosition(id) {
            const el = document.getElementById(id);

            if (el !== null) {
                const topPosition = el.offsetTop - 20;
                window.scrollTo({ top: topPosition, behavior: "smooth" });
            }
        },
        async useFetch(url, data) {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.head.querySelector(
                        "meta[name=csrf-token]",
                    ).content,
                },
                body: JSON.stringify(data),
            });

            return response.json();
        },
        async checkBusSeatsAvailability() {
            try {
                this.serverMessage = null;
                this.seatList = [];
                this.pendingSeatList = [];
                this.bookedSeatsList = [];
                this.selectedSeatsList = [];
                this.bookingInfo = null;

                const departure_id = window.location.pathname.split("/")[4];

                const response = await this.useFetch(
                    "/check_bus_seats_availability",
                    {
                        departure_id,
                    },
                );

                if ("message" in response.data) {
                    this.serverMessage = response.data.message;
                    return;
                }

                this.busInfo = response.data.bus;
                this.seatList = response.data.seat_planning;
                this.bookedSeatsList = response.data.booked_seats;
                this.pendingSeatList = response.data.pending_seats;
                this.departureInfo = response.data.bus_departure;
            } catch (e) {
                console.error(e);
            }
        },
        handleSelectedSeats(seatNumber) {
            if (
                this.bookedSeatsList.includes(seatNumber) ||
                this.pendingSeatList.includes(seatNumber)
            ) {
                return;
            }

            const selectedSeatIdx = this.selectedSeatsList.findIndex(
                (seat) => seat === seatNumber,
            );

            this.bookingInfo = null;

            if (selectedSeatIdx !== -1) {
                this.selectedSeatsList.splice(selectedSeatIdx, 1);
                return;
            }

            this.selectedSeatsList.push(seatNumber);
        },
        async handleBookings() {
            if (this.selectedSeatsList.length === 0) {
                return;
            }

            try {
                const data = {
                    departure_id: this.departureInfo.id,
                    number_of_seats: this.selectedSeatsList.length,
                };

                const response = await this.useFetch("/confirm_booking", data);
                this.bookingInfo = response.data;

                this.$nextTick(() => {
                    this.useScrollToPosition("booking_section");
                });
            } catch (e) {
                console.error(e);
            }
        },
    },
}).mount("#vue-app");
