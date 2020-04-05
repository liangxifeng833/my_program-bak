/*
 * 有序查找(斐波那契查找) 
 * 2015-08-22
 */
#include<stdio.h>
#include<string.h>
#include<math.h>
//计算斐波那契数列 数组
void fiboArr(int *f)
{
    f[0] = 1; 
    f[1] = 1; 
    int i; 
    for(i=2; i<20; i++)
    {
        f[i] = f[i-1]+f[i-2]; 
    }
}
//斐波那契查找主函数
int fibo_search(int *a, int n, int key)
{ 
    int F[20] = {0}; 
    fiboArr(F); 
    int low, high, mid, i, k;  
    //最低下标为记录首位
    low = 1; 
    //最高下标为记录末位
    high = n; 
    k = 0; 
    //查找n位于数列的位置
    while(n>F[k]-1)
    {
        k++; 
    }
    //将不满数组补全
    for(i=n; i<F[k]-1; i++)
    {
        a[i]=a[n];
    }
    while(low<=high)
    {
        //计算当前分割下标
        mid = low+F[k-1]-1; 
        printf("mid = %d\n", mid); 
        if(key>a[mid])
        {
            low = mid+1; 
            k=k-2; 
        }else if(key<a[mid])
        {
            high = mid-1; 
            k=k-1; 
        }else
        {
            if(mid<=n)
            {
                return mid;
            }else
            {
                //mid>n说明查找到的是不全的数值，返回n
                return n; 
            }
        }
    }
    return 0; 
}

main(void)
{
    int arr[] = {0, 1, 16, 24, 25, 35, 47, 59, 62, 73, 88, 99}; 
    int len, key; 
    len = sizeof(arr)/sizeof(int); 
    printf("please input search int:"); 
    scanf("%d", &key); 
    int res = fibo_search(arr, len, key); 
    if(res == 0)
    {
        printf("search failed!\n"); 
        return; 
    }
    printf("search seccess!\n"); 
}
