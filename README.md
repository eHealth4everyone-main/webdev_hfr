
# Frontend Project - Built with Next.js, Redux, and Tailwind CSS

This is a modern frontend project built using [Next.js](https://nextjs.org/), [Redux](https://redux.js.org/), and [Tailwind CSS](https://tailwindcss.com/). It includes basic state management using Redux and a responsive UI powered by Tailwind CSS.

## Table of Contents
- [Features](#features)
- [Technologies](#technologies)
- [Installation](#installation)
- [Usage](#usage)
- [Folder Structure](#folder-structure)
- [Contributing](#contributing)
- [License](#license)

## Features
- **Next.js**: Fast, server-rendered React framework with automatic static optimization.
- **Redux**: Centralized state management for React applications.
- **Tailwind CSS**: Utility-first CSS framework for building responsive and customizable UI components.
- **Responsive Design**: The application is fully responsive and optimized for all screen sizes.
- **Dark Mode**: A simple dark mode feature can be toggled with a button.
- **API Integration**: Fetch data from REST APIs and display it in a user-friendly format.

## Technologies
- **Next.js**: Framework for server-side rendering and static site generation.
- **Redux**: State management library for JavaScript apps.
- **Tailwind CSS**: A utility-first CSS framework.
- **React**: A JavaScript library for building user interfaces.
- **Redux Toolkit**: A library for efficient Redux development.
- **TypeScript**: TypeScript for type safety (if you use TypeScript in your project).

## Installation

Follow these steps to set up the project locally:

### 1. Clone the repository

```bash
git clone https://gitlab.com/e4e-webdev2/hfr.git
```

### 2. Navigate into the project directory

```bash
cd hfr
```

### 3. Install dependencies

```bash
npm install
```

or if you use Yarn:

```bash
yarn install
```

### 4. Run the development server

```bash
npm run dev
```

or with Yarn:

```bash
yarn dev
```

Your application should now be running at [http://localhost:3000](http://localhost:3000).

## Usage

Once the project is running, you can use the following features:

- **State Management**: Redux is used to manage global state. You can access and dispatch actions using `useSelector` and `useDispatch`.
- **Responsive Design**: Tailwind CSS utilities are used to build the UI. You can adjust the design for various screen sizes with simple classes.
- **API Integration**: You can fetch data from APIs using the built-in Next.js `getServerSideProps` or `getStaticProps` functions.

## Folder Structure

Here's an overview of the project structure:

```
/app
  ├── MainLayout.tsx       # Global setup, includes Redux Provider and Tailwind setup
  ├── index.tsx      # Home page
  ├── about.tsx      # About page
  ├── ...           # Other pages
/components
  ├── Header.tsx     # Header component
  ├── Footer.tsx     # Footer component
  ├── ...           # Other UI components
/redux
  ├── store.tsx      # Redux store configuration
  ├── actions.tsx    # Redux actions
  ├── reducers.tsx   # Redux reducers
  ├── slices        # Redux slice files
/styles
  ├── globals.css   # Global styles, Tailwind CSS imports
/public
  ├── images        # Public images
  ├── favicon.ico   # Favicon
```

## Contributing

If you'd like to contribute to this project, feel free to fork the repository, create a branch, and submit a pull request. Be sure to follow the code style conventions and include relevant tests.

1. Fork the repository
2. Create your branch (`git checkout -b feature/your-feature-name`)
3. Commit your changes (`git commit -m 'Add your feature'`)
4. Push to the branch (`git push origin feature/your-feature-name`)
5. Open a pull request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
