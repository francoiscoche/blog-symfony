# blog-symfony
Blog app with Symfony and Docker. Made to learn.



*Developpement in progress ...*

- Integration of [Slugify](https://github.com/cocur/slugify) to generate post slugs.
- Integration of [VichUploaderBundle](https://github.com/dustin10/VichUploaderBundle) for images uploading.
- Integration of [DoctrineFixturesBundle](https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html) and [FakePHP](https://fakerphp.github.io/) for generating false test data.
- Integration of TailWindCss with WebPackEncore from this [tutorial](https://www.yourigalescot.com/fr/blog/comment-integrer-tailwindcss-v3-a-un-projet-symfony-avec-webpack-encore).
- Integration of [TailWindElement](https://tailwind-elements.com/quick-start/) (Bootstrap components recreated with tailwind css).
- Integration of [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) to use a pagination system.


### Requirements

- Docker
- Docker-compose

### Installation

```bash
  docker-compose build
  docker-compose up -d
```

*The application is available at http://127.0.0.1:9000*

### UML

<img width="500" alt="uml" src="https://user-images.githubusercontent.com/102531037/199607904-e6f927d8-6f70-41c3-86ee-260807757ee3.png">


### Author

Inspired by [@Emilien.Gts](https://gitlab.com/Emilien.Gts)
Adapted by [@francoiscoche](https://github.com/francoiscoche)
