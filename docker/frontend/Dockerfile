# Use an official Node.js image as the base image
FROM node:17-alpine

# Set the working directory inside the container
WORKDIR /app

RUN pwd
RUN ls -la

# Install app dependencies
RUN npm install react-redux
# Copy package.json and package-lock.json to the container
COPY package*.json ./
RUN ls -la
RUN npm i

# Copy the rest of the app's source code to the container
COPY . .

# Build the React app
#RUN npm run build
#RUN npm run start

# Command to start the app
#CMD ["npm", "start"]
