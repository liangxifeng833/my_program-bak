/*
 * C语言实现朴素模式匹配算法
 * 在主字串s中查找字串t，如果匹配成功则返回t在s中出现的位置
 * date:2015-05-18
 */
#include<stdio.h>
void main(int argc, char *argv[])
{
    char s[] = "abcabcdefg"; 
    char t[] = "abcdefi"; 
    int sLen = sizeof(s)-1;  //s的长度
    int tLen = sizeof(t)-1;  //t的长度
    int i=0, j=0; 
    while(i<sLen  && j<tLen)
    {
        if(s[i] == t[j])
        {
            ++i; 
            ++j; 
        }else
        {
            i = i-j+1; 
            j=0; 
        }
    }
    if(j == tLen)
    {
        printf("匹配成功，t在s中的第一个位置是%d\n", i-j); 
    }else
    {
        printf("匹配失败\n"); 
    }
}
