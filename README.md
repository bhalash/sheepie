![](screenshot.png)

# Sheepie
Sheepie is a light, bottom-up responsive WordPress theme, designed for performance and extension: minimal JavaScript, optimized CSS and an easily-extensible assets pipeline.

## Demo
I use Sheepie for my [own site](http://www.bhalash.com). 

## Installation
I use [Gulp](http://gulpjs.com/) to build assets, which requires [Node.js](https://nodejs.org/en/) in turn.

    git clone --recursive https://github.com/bhalash/sheepie /path/to/wp-content/themes/sheepie
    cd /path/to/wp-content/themes/sheepie
    npm install
    npm run build

## Development
To produce [source maps](http://thesassway.com/intermediate/using-source-maps-with-sass):

    npm run dev

## Licenses
#### Sheepie
All first-party code in Sheepie is licensed under the GPL v3 or later. 

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public > License, version 3, as published by the Free Software Foundation.
>
> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
>
> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
> 
> A copy of the license is included in the root of the plugin’s directory. The file is named LICENSE.

#### Normalize.css
[Normalize.css](https://github.com/necolas/normalize.css/) is included under the MIT License v2:

> Copyright © Nicolas Gallagher and Jonathan Neal
> 
> Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
> 
> The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
> 
> THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

### Charon, Article-Images and Social-Meta
[Charon](https://github.com/bhalash/charon), [Article-Images](https://github.com/bhalash/article-images) and [Social-Meta](https://github.com/bhalash/social-meta) were authored by me and are each included under the MIT License v2.
