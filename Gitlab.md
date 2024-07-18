 ## Support Engineer Take-home Assessment, Intermediate+

**Important:**

- **Please note that [markdown](https://www.markdownguide.org/getting-started/) is the required format for your submission.** To ensure a speedy process, please do not submit other formats, such as PDF. There are several tools, such as [Dillinger](https://dillinger.io/), that can be used to verify your Markdown before submission.


- **While working on this assessment, you can consult external sources, but you must cite them.** GitLab wants to see how you use tools and language; please cite all tools and sources used. When using AI, please add which one you used and the exact phrase you prompted. **Failure to cite sources or tools (including AI) may result in the end of your candidacy.**


1. Write a Ruby or Bash script that will print usernames of all users on a Linux system
   together with their home directories. Here's some example output:

   ```
   gitlab:/home/gitlab
   nobody:/nonexistent
   .
   .
   ```
   
   Each line is a concatenation of a username, the colon
   character (`:`), and the home directory path for that username. Your script
   should output such a line for each user on the system.
   
   Next, write a second script that:

   * Takes the full output of your first script and converts it to an MD5 hash.
   * On its first run stores the MD5 checksum into the `/var/log/current_users` file.
   * On subsequent runs, if the MD5 checksum changes, the script should add a line in
     the `/var/log/user_changes` file with the message,
     `DATE TIME changes occurred`, replacing `DATE` and `TIME` with appropriate
     values, and replaces the old MD5 checksum in `/var/log/current_users`
     file with the new MD5 checksum.

   Finally, write a crontab entry that runs these scripts hourly.

   Provide both scripts and the crontab entry for the answer to be
   complete.


1. A user is complaining that it's taking a long time to load a page on our
   web application. In your own words, write down and discuss the possible
   cause(s) of the slowness. Also describe how you would begin to troubleshoot
   this issue?

   Keep the following information about the environment in mind:

   * The web application is written in a modern MVC web framework.
   * Application data is stored in a relational database.
   * All components (web application, web server, database) are running on a single
     Linux box with 8GB RAM, 2 CPU cores, and SSD storage with ample free space.
   * You have root access to this Linux box.

   We are interested in learning about your experience with modern web
   applications, and your ability to reason about system design and
   architectural trade-offs. There is no right or wrong answer to this
   question. Feel free to write as much or as little as you feel is necessary.


1. The Git commit graph below shows the output of `git log --all --decorate --oneline --graph`. What sequence of Git commands would result in this commit graph when starting from an empty directory?

```
* 3ceaba9 (HEAD -> master) fourth commit
*   6b5b81f Merge
|\
| * 9f22672 (feature-branch) awesome feature
* | 572982b third commit
|/
* 87acf21 second commit
* 5662bb5 first commit
```

1. GitLab has hired you to write a Git tutorial for beginners on this topic:

   **Using Git to implement a new feature/change without affecting the main branch**
   
   In your own words, write a tutorial/blog explaining things in a beginner-friendly way. 
   Make sure to address both the "why" and "how" for each Git command you use.  Assume 
   the audience are readers of a well known blog.

   (**Note**: This is just a scenario for you to demonstrate your written skills and ability to explain technical topics. We are not using these assessments for anything other than the recruitment process.)

1. What is a technical book/blog you read recently that you enjoyed? 
Please include a brief review of what you especially liked or didn’t like about it.
