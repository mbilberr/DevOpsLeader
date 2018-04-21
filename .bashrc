case $- in
    *i*) ;;
      *) return;;
esac

#
# Environment
#

HISTCONTROL=ignoreboth
HISTSIZE=1000
HISTFILESIZE=2000
TERM=xterm-256color
PS1='${debian_chroot:+($debian_chroot)}\[\033[01;32m\]\u[\[\033[01;34m\]\w\[\033[00m\]] '
shopt -s histappend
shopt -s checkwinsize
test -r ~/.dircolors && eval "$(dircolors -b ~/.dircolors)" || eval "$(dircolors -b)"

#
# Aliases
#

alias ls='ls --color=auto'
alias grep='grep --color=auto'
alias fgrep='fgrep --color=auto'
alias egrep='egrep --color=auto'
alias ll='ls -alF'
alias 1='ls -CF'

#
# Autocomplete
#

. /usr/share/bash-completion/bash_completion
[ -x /usr/bin/lesspipe ] && eval "$(SHELL=/bin/sh lesspipe)"
