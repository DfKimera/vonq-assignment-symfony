# Backend PHP Assignment
This document describes the evaluation assignment for the position of a Backend
Engineer.

Required technologies to use are: PHP.

Preferable, but not required, technologies to use are: Symfony framework

## Techniques:
 - Object Oriented
 - Code should follow SOLID principles
 - 3rd party libraries should be installed with a package manager, like Composer

## General Info

What are we assessing
 - Application architecture
 - REST API Design skills
 - Coding style & quality overall
 - Programming patterns

On theoretical level, we are looking into:
 - Communication skills
 - High performance design skills

In general architectural choices are important to us.

## What are we NOT assessing

We do not expect beautiful pages. You should consider that a frontend developer will be
giving a hand to make things pretty in an actual team.

## Time

We understand that you are busy with more things, so the time you can afford to put on
any parts of this assignment depends on you.
However we would like to know when (date) you expect to come back to us with your
solution, and how long you expect it would take you. See it as a mini project. Also in real
life scenario, you would be giving a guestimate and commit to a milestone, right?

## The Exercise

### A bit of context
Let’s assume we are a startup that wants to build a social network application to manage
people’s connections in a high traffic scenario (millions of unique visitors per month).
Yes... We are ambitious! ;-)

People connect in groups to meet regularly. The website has registered users and the
goal of the application is to create connections within the users and facilitate them to
organize meetings within their groups. The users can be logging in with their
linkedin/facebook/local account.

Let’s also assume that a user can RSVP on a meeting of a group and that all users can
access a (near-real) time report on a group and meeting popularity.
We know it may seem familiar...but fear not! We will not be asking you to implement the
whole meetup.com ;-)

It is just to give you context, perhaps inspire you regarding domain model and help us
describe the exercise in hand...

### The (actual) assignment
#### A. ​REST Service
The heart of this social network application should be a REST service that facilitates
social networking functionality:
- request to create a relationship with a fellow user in a group
- list of a user’s current connections (with different filtering possibilities...you can
improvise on this)
The input and output for this REST service is for you to define. We would love to see how
you would design and implement such REST API.
#### B. Data
The structure of the repository to accommodate user connections is for you to define.
#### C. To UI or not UI?
Give us a way to see your API in action, and if you like, optionally, you can surprise us
with any FE skills... and, no worries, remember we won’t be shocked if the UI looks ugly
or you fall back to command line.

What we need is a super simple interface to handle the following functionality:
 - see list of users
 - invite a user to connect
 - see a user’s connections
 - optionally, A way of filtering
 - if you like surprises, anything like search/sorting/paging is more than welcome

## Deliverables
In your submission, we would like you to include:

1. All code (frontend, backend, any QA assets) developed to create this
functionality
2. The DB script that generates the structure and the data to run this application
3. A working app hosted anywhere you like (amazon free tier?) OR installation
instructions

For convenience sake, for points a & b, you can use a code repository like Github or
Bitbucket and share it with us.

## Bonus Questions
1. It’s a big plus if you add (some) tests to your code (let us see your QA skills)
2. Looking at the description of the context, please provide architecture diagram(s)
on how you would technically design the functionality described for this
application in a scalable way. You can decide yourself what types of diagram(s)
will help you communicate to us your thoughts about building such application.
3. Which parts of the application would you have implemented differently and why,
should you have more time?
4. If we would have asked you to unit test your code with 80% code coverage,
which parts would you cover, which not and why. How would you be able to verify
and prove to us that you achieve such coverage?

Thank you upfront for your time and effort and for allowing us to see you in action!