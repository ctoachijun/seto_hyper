# .bashrc
export PS1="[\u@ \W]\$ "
alias ll='ls -l --color=auto' 2>/dev/null
alias ls='ls --color=auto' 2>/dev/null
export LANG="ko_KR.UTF-8"

# Source global definitions
if [ -f /etc/bashrc ]; then
        . /etc/bashrc
fi

# Uncomment the following line if you don't like systemctl's auto-paging feature:
# export SYSTEMD_PAGER=

# User specific aliases and functions
